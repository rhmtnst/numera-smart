<?php

namespace App\Http\Controllers;

use App\Models\AssessmentAttempt;
use App\Models\AnswerAnalysis;
use Illuminate\Http\Request;
use App\Models\RemedialMaterial;
use App\Models\NewmanFinding;
use App\Support\TeacherScope;
use App\Models\AssessmentTopicReview;
use App\Models\RemedialAttempt;

class TeacherAnalysisController extends Controller
{
    private function authorizeTeacher(): void
    {
        abort_unless(
            auth()->user()->role === 'teacher',
            403,
            'Halaman ini hanya dapat diakses guru.'
        );
    }

    /**
     * Menampilkan daftar asesmen yang sudah selesai.
     */
    public function index()
    {
        $this->authorizeTeacher();

        $attempts = TeacherScope::attemptQuery(auth()->user())->with([
            'student.studentProfile',
            'topic',
            'topicReview',
            'answers.analysis',
        ])
            ->where('status', 'completed')
            ->withCount('answers')
            ->latest('completed_at')
            ->paginate(10);

        return view(
            'teacher.analyses.index',
            compact('attempts')
        );
    }

    /**
     * Menampilkan detail analisis satu asesmen.
     */
    
public function show(AssessmentAttempt $attempt)
{
    $this->authorizeTeacher();

    abort_unless(TeacherScope::allowsStudent(auth()->user(), $attempt->student), 404);

    abort_unless(
        $attempt->status === 'completed',
        404
    );

    
$attempt->load([
    'student.studentProfile',
    'topic',
    'answers.question.options',

    'answers.analysis.newmanFindings.remedialRecommendations.remedialMaterial',
    'answers.analysis.newmanFindings.remedialRecommendations.recommender',

    // Ambil riwayat remediasi hanya milik siswa yang sedang dianalisis.
    'answers.analysis.newmanFindings.remedialRecommendations.remedialAttempts' =>
        function ($query) use ($attempt) {
            $query->where('student_id', $attempt->student_id)
                ->withCount([
                    'answers',
                    'answers as correct_answers_count' => function ($answerQuery) {
                        $answerQuery->where('is_correct', true);
                    },
                    'answers as wrong_answers_count' => function ($answerQuery) {
                        $answerQuery->where('is_correct', false);
                    },
                ])
               ->orderBy('started_at', 'asc');
        },

       'answers.analysis.reviewer',
    'answers.analysis.verificationResponses.verificationQuestion',
    'topicReview.reviewer',
]);


    // Ambil materi remediasi yang sesuai dengan topik asesmen.
    $remedialMaterials = collect();

    if ($attempt->topic_id) {
       $remedialMaterials = RemedialMaterial::with([
        'topic',
        'newmanStages',
    ])
    ->where('topic_id', $attempt->topic_id)
    ->where('status', 'published')
    ->whereHas('exercises', function ($query) {
        $query->where('is_active', true);
    })
    ->whereHas('newmanStages')
    ->orderByDesc('published_at')
    ->get();
    }

    $stageLabels = [
        'reading' => 'Membaca',
        'comprehension' => 'Memahami',
        'transformation' => 'Transformasi',
        'process_skills' => 'Keterampilan Proses',
        'encoding' => 'Menuliskan Jawaban',
    ];

    $allFindings = $attempt->answers
        ->flatMap(fn ($answer) => $answer->analysis?->newmanFindings ?? collect());

    $newmanSummary = collect($stageLabels)->map(function ($label, $stage) use ($allFindings, $attempt) {
        $stageFindings = $allFindings->where('stage', $stage);
        $assessed = $stageFindings->whereIn('finding_status', ['error_indicated', 'no_error_indicated']);
        $errors = $stageFindings->where('finding_status', 'error_indicated')->count();

        return [
            'stage' => $stage,
            'label' => $label,
            'total' => $stageFindings->count(),
            'assessed' => $assessed->count(),
            'errors' => $errors,
            'insufficient' => $stageFindings->where('finding_status', 'insufficient_evidence')->count(),
            'percentage' => $assessed->count() > 0 ? round(($errors / $assessed->count()) * 100) : 0,
            'question_numbers' => $attempt->answers
                ->filter(fn ($answer) => $answer->analysis?->newmanFindings
                    ->contains(fn ($finding) => $finding->stage === $stage && $finding->finding_status === 'error_indicated'))
                ->keys()->map(fn ($key) => $key + 1)->values()->all(),
        ];
    })->values();

    $topicReview = $attempt->topicReview;
    $analysisReady = $attempt->answers->isNotEmpty() && $attempt->answers->every(fn ($answer) =>
        $answer->analysis && $answer->analysis->analysis_status === 'completed'
    );

    // Rekap hasil remediasi yang benar-benar terkait dengan asesmen/topik ini.
    // Prioritas hubungan eksplisit melalui rekomendasi guru; latihan lama tanpa
    // recommendation_id hanya dimasukkan bila dimulai setelah asesmen ini selesai.
    $remedialAttempts = collect();
    if ($attempt->topic_id) {
        $remedialAttempts = RemedialAttempt::query()
            ->where('student_id', $attempt->student_id)
            ->where('status', 'completed')
            ->whereNotNull('completed_at')
            ->whereHas('material', function ($query) use ($attempt) {
                $query->where('topic_id', $attempt->topic_id);
            })
            ->where(function ($query) use ($attempt) {
                $query->whereHas(
                    'recommendation.newmanFinding.answerAnalysis.studentAnswer',
                    function ($answerQuery) use ($attempt) {
                        $answerQuery->where('assessment_attempt_id', $attempt->id);
                    }
                );

                if ($attempt->completed_at) {
                    $query->orWhere(function ($legacyQuery) use ($attempt) {
                        $legacyQuery->whereNull('remedial_recommendation_id')
                            ->where('started_at', '>=', $attempt->completed_at);
                    });
                }
            })
            ->with(['material', 'recommendation'])
            ->latest('completed_at')
            ->get()
            ->map(function ($remedialAttempt) use ($attempt) {
                $before = (float) $attempt->score;
                $after = (float) $remedialAttempt->score;
                $remedialAttempt->comparison_before = $before;
                $remedialAttempt->comparison_after = $after;
                $remedialAttempt->comparison_change = round($after - $before, 2);
                return $remedialAttempt;
            });
    }

    return view(
        'teacher.analyses.show',
        compact('attempt', 'remedialMaterials', 'newmanSummary', 'topicReview', 'analysisReady', 'remedialAttempts')
    );
}


    /**
     * Menyimpan keputusan verifikasi guru.
     */
    /**
     * Simpan satu keputusan guru untuk keseluruhan diagnosis pada asesmen topik.
     */
    public function reviewTopic(Request $request, AssessmentAttempt $attempt)
    {
        $this->authorizeTeacher();
        abort_unless(TeacherScope::allowsStudent(auth()->user(), $attempt->student), 404);
        abort_unless($attempt->status === 'completed', 404);

        $validated = $request->validate([
            'decision' => ['required', 'in:confirmed,needs_revision'],
            'teacher_notes' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        $answers = $attempt->answers()->with('analysis.newmanFindings')->get();
        abort_if($answers->isEmpty(), 422, 'Asesmen ini belum memiliki jawaban siswa.');
        abort_if(
            $answers->contains(fn ($answer) => !$answer->analysis || $answer->analysis->analysis_status !== 'completed'),
            422,
            'Tunggu sampai seluruh jawaban selesai dianalisis sebelum mengonfirmasi diagnosis topik.'
        );

        $findings = $answers->flatMap(fn ($answer) => $answer->analysis?->newmanFindings ?? collect());
        abort_if($findings->isEmpty(), 422, 'Analisis Newman belum tersedia untuk asesmen ini.');

        AssessmentTopicReview::updateOrCreate(
            ['assessment_attempt_id' => $attempt->id],
            [
                'decision' => $validated['decision'],
                'teacher_notes' => $validated['teacher_notes'],
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]
        );

        return redirect()->route('teacher.analyses.show', $attempt->id)
            ->with('success', $validated['decision'] === 'confirmed'
                ? 'Diagnosis Newman untuk topik ini berhasil dikonfirmasi.'
                : 'Diagnosis ditandai perlu perbaikan. Rekomendasi remedial belum dibuka.');
    }

    public function review(Request $request, AnswerAnalysis $analysis)
    {
        $this->authorizeTeacher();

        $analysis->load('studentAnswer.assessmentAttempt');

        $attempt = $analysis->studentAnswer?->assessmentAttempt;
        if ($attempt) { abort_unless(TeacherScope::allowsStudent(auth()->user(), $attempt->student), 404); }

        abort_unless(
            $attempt && $attempt->status === 'completed',
            404
        );

        $validated = $request->validate([
            'review_decision' => [
                'required',
                'in:confirmed,not_confirmed,needs_follow_up',
            ],
            'teacher_notes' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
        ], [
            'review_decision.required' => 'Keputusan verifikasi harus dipilih.',
            'review_decision.in' => 'Keputusan verifikasi tidak valid.',
            'teacher_notes.required' => 'Catatan guru wajib diisi.',
            'teacher_notes.min' => 'Catatan guru minimal 10 karakter.',
        ]);

        $analysis->update([
            'reviewed_by' => auth()->id(),
            'review_decision' => $validated['review_decision'],
            'teacher_notes' => $validated['teacher_notes'],
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->route('teacher.analyses.show', $attempt->id)
            ->with('success', 'Verifikasi hasil analisis berhasil disimpan.');
    }


/**
 * Menyimpan keputusan guru untuk setiap tahap Newman.
 */
public function reviewFinding(Request $request, NewmanFinding $finding)
{
    $this->authorizeTeacher();

    $finding->load('answerAnalysis.studentAnswer.assessmentAttempt');

    $analysis = $finding->answerAnalysis;
    $attempt = $analysis?->studentAnswer?->assessmentAttempt;
    if ($attempt) { abort_unless(TeacherScope::allowsStudent(auth()->user(), $attempt->student), 404); }

    abort_unless(
        $attempt && $attempt->status === 'completed',
        404
    );

    $validated = $request->validate([
        'teacher_decision' => [
            'required',
            'in:confirmed,not_confirmed,needs_follow_up',
        ],
        'teacher_notes' => [
            'required',
            'string',
            'min:10',
            'max:5000',
        ],
    ], [
        'teacher_decision.required' => 'Keputusan tahap Newman wajib dipilih.',
        'teacher_notes.required' => 'Catatan guru wajib diisi.',
        'teacher_notes.min' => 'Catatan guru minimal 10 karakter.',
    ]);

    $finding->update([
        'teacher_decision' => $validated['teacher_decision'],
        'teacher_notes' => $validated['teacher_notes'],
        'reviewed_by' => auth()->id(),
        'reviewed_at' => now(),
    ]);

    return redirect()
        ->route('teacher.analyses.show', $attempt->id)
        ->with('success', 'Keputusan tahap Newman berhasil disimpan.');
}

}