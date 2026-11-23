<?php

namespace App\Http\Controllers;

use App\Models\AssessmentAttempt;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
use App\Services\NewmanAnalysisService;

class StudentAssessmentController extends Controller
{
    private function authorizeStudent(): void
    {
        abort_unless(
            auth()->user()->role === 'student',
            403,
            'Halaman ini hanya dapat diakses siswa.'
        );
    }

    public function start(Topic $topic)
    {
        $this->authorizeStudent();

        $profile = auth()->user()->studentProfile;

        abort_if(!$profile, 403, 'Profil siswa belum tersedia.');

        abort_unless(
            $topic->grade_level == $profile->grade_level &&
            $topic->is_active &&
            $topic->learningDomain->is_active,
            404
        );

        $questions = $topic->questions()
            ->where('is_active', true)
            ->where('review_status', 'approved')
            ->orderBy('sort_order')
            ->get();

        if ($questions->isEmpty()) {
            return back()->with(
                'error',
                'Belum ada soal yang tersedia untuk topik ini.'
            );
        }

        $attempt = DB::transaction(function () use ($questions, $topic) {

            $attempt = AssessmentAttempt::create([
                'student_id' => auth()->id(),
                'topic_id' => $topic->id,
                'started_at' => now(),
                'status' => 'in_progress',
            ]);

            $attempt->answers()->createMany(
                $questions->map(fn ($question) => [
                    'question_id' => $question->id,
                ])->all()
            );

            return $attempt;
        });

        return redirect()->route(
            'student.assessments.show',
            $attempt->id
        );
    }

    public function show(AssessmentAttempt $attempt)
    {
        $this->authorizeStudent();

        abort_unless(
            $attempt->student_id === auth()->id(),
            403
        );

        $attempt->load([
            'topic',
            'answers.question.options',
        ]);

        return view('student.assessments.show', compact('attempt'));
    }

    
public function saveAnswers(
    
    \Illuminate\Http\Request $request,
    AssessmentAttempt $attempt
) {
    $this->authorizeStudent();

    abort_unless($attempt->student_id === auth()->id(), 403);

    abort_unless($attempt->status === 'in_progress', 403);

    $validated = $request->validate([
        'answers' => ['required', 'array'],
        'answers.*.option_label' => ['nullable', 'string', 'max:10'],
        'answers.*.working_steps' => ['nullable', 'string', 'max:10000'],
        'answers.*.student_explanation' => ['nullable', 'string', 'max:5000'],
    ]);

    \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $attempt) {

        foreach ($validated['answers'] as $answerId => $data) {

            $answer = $attempt->answers()
                ->with('question.options')
                ->findOrFail($answerId);

            $optionLabel = $data['option_label'] ?? null;

            if ($optionLabel !== null) {
                $validOption = $answer->question->options
                    ->contains('option_label', $optionLabel);

                abort_unless($validOption, 422, 'Pilihan jawaban tidak valid.');
            }

            $answer->update([
                'answer_text' => $optionLabel,
                'working_steps' => $data['working_steps'] ?? null,
                'student_explanation' => $data['student_explanation'] ?? null,
                'answered_at' => $optionLabel !== null
                    || !empty($data['working_steps'])
                    || !empty($data['student_explanation'])
                        ? now()
                        : null,
            ]);
        }
    });

    return back()->with('success', 'Jawaban berhasil disimpan!');
}



public function finish(
    AssessmentAttempt $attempt,
    NewmanAnalysisService $analysisService
) {
    $this->authorizeStudent();

    abort_unless($attempt->student_id === auth()->id(), 403);
    abort_unless(
        $attempt->status === 'in_progress',
        403,
        'Asesmen ini sudah diselesaikan.'
    );

    $answers = $attempt->answers()->with('question')->get();
    $totalQuestions = $answers->count();

    $answeredQuestions = $answers->filter(
        fn ($answer) => $answer->answered_at !== null
    )->count();

    if ($answeredQuestions < $totalQuestions) {
        return back()->with(
            'error',
            'Masih ada soal yang belum dijawab. Periksa kembali sebelum menyelesaikan asesmen.'
        );
    }

    // Simpan penilaian dan selesaikan asesmen dalam transaksi singkat.
    // Panggilan Gemini tidak boleh berada di dalam transaksi database.
    DB::transaction(function () use ($attempt, $answers) {
        $earnedPoints = 0;
        $maximumPoints = 0;

        foreach ($answers as $answer) {
            $question = $answer->question;
            $maximumPoints += (int) $question->points;

            $submitted = trim((string) $answer->answer_text);
            $expected = trim((string) $question->correct_answer);

            $isCorrect = $submitted !== ''
                && mb_strtolower($submitted) === mb_strtolower($expected);

            $answer->update(['is_correct' => $isCorrect]);

            if ($isCorrect) {
                $earnedPoints += (int) $question->points;
            }
        }

        $score = $maximumPoints > 0
            ? round(($earnedPoints / $maximumPoints) * 100, 2)
            : 0;

        $attempt->update([
            'status' => 'completed',
            'completed_at' => now(),
            'score' => $score,
        ]);
    });

    // Analisis dilakukan setelah transaksi selesai agar request AI tidak
    // menahan lock SQLite/MySQL selama puluhan detik.
    $analysisFailures = 0;

    foreach ($answers as $answer) {
        try {
            $analysisService->analyze($answer->fresh());
        } catch (\Throwable $exception) {
            report($exception);
            $analysisFailures++;
        }
    }

    $message = $analysisFailures === 0
        ? 'Asesmen berhasil diselesaikan dan analisis Newman telah diproses.'
        : 'Asesmen berhasil diselesaikan. Sebagian analisis belum berhasil diproses dan perlu ditinjau guru.';

    return redirect()
        ->route('student.dashboard')
        ->with('success', $message);
}

}
