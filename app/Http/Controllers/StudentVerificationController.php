<?php

namespace App\Http\Controllers;

use App\Models\AnswerAnalysis;
use App\Models\VerificationQuestion;
use App\Models\VerificationResponse;
use App\Services\NewmanAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentVerificationController extends Controller
{
    private const NEWMAN_STAGES = [
        'reading',
        'comprehension',
        'transformation',
        'process_skills',
        'encoding',
    ];

    /**
     * Pertanyaan hanya diminta pada tahap yang masih membutuhkan bukti.
     * Semua lima tahap Newman diperlakukan dengan aturan yang sama.
     */
    public function show(AnswerAnalysis $analysis)
    {
        abort_unless(auth()->check() && auth()->user()->role === 'student', 403);

        $analysis->load([
            'studentAnswer.assessmentAttempt',
            'newmanFindings',
            'verificationResponses',
        ]);

        $studentAnswer = $analysis->studentAnswer;
        $attempt = $studentAnswer?->assessmentAttempt;

        abort_if(!$attempt, 404);
        abort_unless((int) $attempt->student_id === (int) auth()->id(), 403);
        abort_unless($attempt->status === 'completed', 403);

        $eligibleStages = $analysis->newmanFindings
            ->where('finding_status', 'insufficient_evidence')
            ->pluck('stage')
            ->intersect(self::NEWMAN_STAGES)
            ->values();

        $answeredQuestionIds = $analysis->verificationResponses
            ->pluck('verification_question_id')
            ->unique()
            ->values();

        $questions = VerificationQuestion::query()
            ->where(function ($query) use ($eligibleStages, $answeredQuestionIds) {
                $query->where(function ($activeQuery) use ($eligibleStages) {
                    $activeQuery->where('is_active', true)
                        ->whereIn('target_stage', $eligibleStages);
                });

                if ($answeredQuestionIds->isNotEmpty()) {
                    $query->orWhereIn('id', $answeredQuestionIds);
                }
            })
            ->where(function ($query) use ($attempt) {
                $query->whereNull('topic_id')
                    ->orWhere('topic_id', $attempt->topic_id);
            })
            ->orderByRaw("
                CASE target_stage
                    WHEN 'reading' THEN 1
                    WHEN 'comprehension' THEN 2
                    WHEN 'transformation' THEN 3
                    WHEN 'process_skills' THEN 4
                    WHEN 'encoding' THEN 5
                    ELSE 6
                END
            ")
            ->orderBy('sort_order')
            ->get();

        $responses = $analysis->verificationResponses
            ->keyBy('verification_question_id');

        $availableStages = $questions->pluck('target_stage')->unique();
        $missingStages = $eligibleStages->diff($availableStages)->values();

        return view('student.verifications.show', compact(
            'analysis',
            'questions',
            'responses',
            'eligibleStages',
            'missingStages'
        ));
    }

    /**
     * Menyimpan seluruh jawaban verifikasi yang sedang diminta, kemudian
     * menjalankan ulang analisis agar jawaban tersebut menjadi bukti AI.
     */
    public function store(
        Request $request,
        AnswerAnalysis $analysis,
        NewmanAnalysisService $newmanAnalysisService
    ) {
        abort_unless(auth()->check() && auth()->user()->role === 'student', 403);

        $analysis->load([
            'studentAnswer.assessmentAttempt',
            'newmanFindings',
        ]);

        $studentAnswer = $analysis->studentAnswer;
        $attempt = $studentAnswer?->assessmentAttempt;

        abort_if(!$attempt, 404);
        abort_unless((int) $attempt->student_id === (int) auth()->id(), 403);
        abort_unless($attempt->status === 'completed' && $attempt->completed_at !== null, 403);
        abort_unless($analysis->analysis_status === 'completed', 403);

        if ($analysis->reviewed_at !== null) {
            return redirect()
                ->route('student.verifications.show', $analysis)
                ->with('info', 'Guru sudah memeriksa analisis ini. Kamu tidak perlu mengirim jawaban verifikasi lagi.');
        }

        $eligibleStages = $analysis->newmanFindings
            ->where('finding_status', 'insufficient_evidence')
            ->pluck('stage')
            ->intersect(self::NEWMAN_STAGES)
            ->values();

        $questions = VerificationQuestion::query()
            ->where('is_active', true)
            ->whereIn('target_stage', $eligibleStages)
            ->where(function ($query) use ($attempt) {
                $query->whereNull('topic_id')
                    ->orWhere('topic_id', $attempt->topic_id);
            })
            ->get();

        if ($questions->isEmpty()) {
            return redirect()
                ->route('student.verifications.show', $analysis)
                ->with('info', 'Tidak ada pertanyaan verifikasi aktif yang perlu dijawab saat ini. Hasil analisis akan ditinjau guru.');
        }

        $validated = $request->validate([
            'responses' => ['required', 'array'],
            'responses.*' => ['required', 'string', 'min:2', 'max:5000'],
        ], [
            'responses.required' => 'Jawaban verifikasi belum diisi.',
            'responses.*.required' => 'Isi semua pertanyaan verifikasi yang ditampilkan.',
            'responses.*.min' => 'Jawaban terlalu singkat. Ceritakan cara berpikirmu.',
        ]);

        $allowedIds = $questions->pluck('id')->map(fn ($id) => (string) $id)->all();
        $submittedIds = array_map('strval', array_keys($validated['responses']));

        foreach ($submittedIds as $questionId) {
            abort_unless(in_array($questionId, $allowedIds, true), 403);
        }

        $missingIds = array_diff($allowedIds, $submittedIds);
        if (!empty($missingIds)) {
            return back()
                ->withErrors(['responses' => 'Jawab semua pertanyaan verifikasi sebelum menyimpan.'])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $analysis) {
            foreach ($validated['responses'] as $questionId => $responseText) {
                $response = VerificationResponse::firstOrNew([
                    'answer_analysis_id' => $analysis->id,
                    'verification_question_id' => $questionId,
                ]);

                $response->response_text = trim($responseText);
                $response->asked_at ??= now();
                $response->answered_at = now();
                $response->save();
            }
        });

        $newmanAnalysisService->analyze($studentAnswer->fresh());

        return redirect()
            ->route('student.verifications.show', $analysis)
            ->with('success', 'Jawaban verifikasi tersimpan. Analisis Newman diperbarui menggunakan bukti tambahan.');
    }
}
