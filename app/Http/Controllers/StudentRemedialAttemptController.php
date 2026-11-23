<?php

namespace App\Http\Controllers;

use App\Models\RemedialMaterial;
use App\Models\RemedialAttempt;
use App\Models\RemedialRecommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentRemedialAttemptController extends Controller
{
    /**
     * Memastikan pengguna adalah siswa.
     */
    private function authorizeStudent(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->role === 'student',
            403,
            'Halaman ini hanya dapat diakses siswa.'
        );
    }

    /**
     * Memperbarui status rekomendasi.
     * Status hanya boleh bergerak maju.
     */
    private function updateRecommendationStatus(
        ?int $recommendationId,
        string $status
    ): void {
        if (!$recommendationId) {
            return;
        }

        $query = RemedialRecommendation::query()
            ->whereKey($recommendationId);

        if ($status === 'in_progress') {
            $query->where('status', 'pending');
        } elseif ($status === 'completed') {
            $query->where('status', 'in_progress');
        } else {
            return;
        }

        $query->update([
            'status' => $status,
        ]);
    }

    /**
     * Memastikan siswa memiliki profil dan materi aktif.
     */
    private function authorizeMaterial(
        RemedialMaterial $remedial,
        $student
    ): void {
        $profile = $student->studentProfile;

        abort_if(
            !$profile,
            403,
            'Profil siswa belum tersedia.'
        );

        $remedial->loadMissing('topic.learningDomain');

        abort_unless(
            $remedial->status === 'published' &&
            $remedial->topic &&
            $remedial->topic->grade_level == $profile->grade_level &&
            $remedial->topic->is_active &&
            $remedial->topic->learningDomain &&
            $remedial->topic->learningDomain->is_active,
            404
        );
    }

    /**
     * Memulai latihan remediasi.
     */
    public function start(Request $request, RemedialMaterial $remedial)
    {
        $this->authorizeStudent();

        $student = auth()->user();

        $this->authorizeMaterial($remedial, $student);

        $exercises = $remedial->exercises()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        abort_if($exercises->isEmpty(), 404);

        $recommendation = null;

        // Validasi rekomendasi guru jika latihan berasal dari rekomendasi.
        if ($request->filled('recommendation_id')) {
            $recommendation = RemedialRecommendation::query()
                ->whereKey($request->input('recommendation_id'))
                ->where('remedial_material_id', $remedial->id)
                ->whereHas('newmanFinding', function ($query) {
                    $query
                        ->where('finding_status', 'error_indicated')
                        ->whereNotNull('reviewed_at')
                        ->where('teacher_decision', 'confirmed')
                        ->whereHas('answerAnalysis', function ($analysisQuery) {
                            $analysisQuery
                                ->whereNotNull('reviewed_at')
                                ->where('review_decision', 'confirmed')
                                ->whereHas('studentAnswer.assessmentAttempt', function ($attemptQuery) {
                                    $attemptQuery->where('status', 'completed')
                                        ->whereNotNull('completed_at')
                                        ->whereHas('topicReview', function ($reviewQuery) {
                                            $reviewQuery->where('decision', 'confirmed')
                                                ->whereNotNull('reviewed_at');
                                        });
                                });
                        });
                })
                ->whereHas(
                    'newmanFinding.answerAnalysis.studentAnswer.assessmentAttempt',
                    function ($query) use ($student) {
                        $query
                            ->where('student_id', $student->id)
                            ->where('status', 'completed')
                            ->whereNotNull('completed_at');
                    }
                )
                ->firstOrFail();
        }

        // Periksa latihan aktif yang sudah ada.
        $existingAttemptQuery = RemedialAttempt::query()
            ->where('student_id', $student->id)
            ->where('remedial_material_id', $remedial->id)
            ->where('status', 'in_progress');

        if ($recommendation) {
            $existingAttemptQuery->where(
                'remedial_recommendation_id',
                $recommendation->id
            );
        } else {
            $existingAttemptQuery->whereNull(
                'remedial_recommendation_id'
            );
        }

        $existingAttempt = $existingAttemptQuery
            ->latest('started_at')
            ->first();

        if ($existingAttempt) {
            return redirect()->route(
                'student.remedials.attempts.show',
                $existingAttempt
            );
        }

        // Buat percobaan dan daftar jawaban dalam satu transaksi.
        $attempt = DB::transaction(function () use (
            $remedial,
            $student,
            $exercises,
            $recommendation
        ) {
            $attempt = RemedialAttempt::create([
                'remedial_material_id' => $remedial->id,
                'remedial_recommendation_id' => $recommendation?->id,
                'student_id' => $student->id,
                'started_at' => now(),
                'status' => 'in_progress',
            ]);

            foreach ($exercises as $exercise) {
                $attempt->answers()->create([
                    'remedial_exercise_id' => $exercise->id,
                ]);
            }

            if ($recommendation) {
                $this->updateRecommendationStatus(
                    $recommendation->id,
                    'in_progress'
                );
            }

            return $attempt;
        });

        return redirect()->route(
            'student.remedials.attempts.show',
            $attempt
        );
    }

    /**
     * Menampilkan halaman pengerjaan latihan.
     */
    public function show(RemedialAttempt $attempt)
    {
        $this->authorizeStudent();

        abort_unless(
            $attempt->student_id === auth()->id(),
            403,
            'Kamu tidak memiliki akses ke latihan ini.'
        );

        if ($attempt->status === 'completed') {
            return redirect()->route(
                'student.remedials.attempts.result',
                $attempt
            );
        }

        abort_unless(
            $attempt->status === 'in_progress',
            403,
            'Latihan ini tidak dapat dikerjakan.'
        );

        $attempt->load([
            'material.topic.learningDomain',
            'answers.exercise',
        ]);

        $student = auth()->user();

        $this->authorizeMaterial(
            $attempt->material,
            $student
        );

        return view(
            'student.remedials.attempt',
            compact('attempt')
        );
    }

    /**
     * Menyimpan jawaban latihan siswa.
     */
    public function saveAnswer(
        Request $request,
        RemedialAttempt $attempt
    ) {
        $this->authorizeStudent();

        abort_unless(
            $attempt->student_id === auth()->id(),
            403,
            'Kamu tidak memiliki akses ke latihan ini.'
        );

        abort_unless(
            $attempt->status === 'in_progress',
            403,
            'Latihan ini sudah selesai.'
        );

        $attempt->load('material.topic.learningDomain');

        $this->authorizeMaterial(
            $attempt->material,
            auth()->user()
        );

        $validated = $request->validate([
            'remedial_answer_id' => ['required', 'integer'],
            'answer_text' => ['required', 'string', 'max:1000'],
        ]);

        $answer = $attempt->answers()
            ->whereKey($validated['remedial_answer_id'])
            ->firstOrFail();

        $answer->load('exercise');

        abort_unless(
            $answer->exercise &&
            $answer->exercise->is_active,
            404
        );

        $answer->update([
            'answer_text' => $validated['answer_text'],
            'answered_at' => now(),
        ]);

        return back()->with(
            'success',
            'Jawaban berhasil disimpan.'
        );
    }

    /**
     * Mengumpulkan dan menilai latihan remediasi.
     */
    public function submit(RemedialAttempt $attempt)
    {
        $this->authorizeStudent();

        abort_unless(
            $attempt->student_id === auth()->id(),
            403,
            'Kamu tidak memiliki akses ke latihan ini.'
        );

        $result = DB::transaction(function () use ($attempt) {
            // Ambil ulang data terbaru dan kunci selama proses penilaian.
            $lockedAttempt = RemedialAttempt::query()
                ->whereKey($attempt->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                $lockedAttempt->student_id === auth()->id(),
                403,
                'Kamu tidak memiliki akses ke latihan ini.'
            );

            abort_unless(
                $lockedAttempt->status === 'in_progress',
                403,
                'Latihan ini sudah dikumpulkan.'
            );

            $lockedAttempt->load('answers.exercise');

            // Pastikan seluruh soal sudah dijawab.
            $unanswered = $lockedAttempt->answers->contains(
                function ($answer) {
                    return $answer->answer_text === null ||
                        trim($answer->answer_text) === '';
                }
            );

            if ($unanswered) {
                return false;
            }

            $totalPoints = 0;
            $earnedPoints = 0;

            foreach ($lockedAttempt->answers as $answer) {
                $exercise = $answer->exercise;

                abort_unless(
                    $exercise && $exercise->is_active,
                    409,
                    'Terdapat soal yang sudah tidak aktif. Hubungi guru.'
                );

                $studentAnswer = trim($answer->answer_text);
                $correctAnswer = trim($exercise->correct_answer ?? '');

                // Normalisasi teks terlebih dahulu agar perbedaan kapitalisasi
                // dan spasi tidak memengaruhi penilaian.
                $normalizedStudent = mb_strtolower(
                    preg_replace('/\s+/u', ' ', $studentAnswer)
                );
                $normalizedCorrect = mb_strtolower(
                    preg_replace('/\s+/u', ' ', $correctAnswer)
                );

                $isCorrect = $normalizedStudent === $normalizedCorrect;

                // Untuk jawaban numerik sederhana, koma dan titik desimal
                // diperlakukan setara (mis. 1,5 dan 1.5). Satuan/teks tidak
                // dihapus agar jawaban dengan makna berbeda tidak disamakan.
                if (!$isCorrect) {
                    $numericStudent = str_replace(',', '.', trim($studentAnswer));
                    $numericCorrect = str_replace(',', '.', trim($correctAnswer));

                    if (is_numeric($numericStudent) && is_numeric($numericCorrect)) {
                        $isCorrect = abs((float) $numericStudent - (float) $numericCorrect) < 0.000001;
                    }
                }

                $points = (int) $exercise->points;

                $totalPoints += $points;

                if ($isCorrect) {
                    $earnedPoints += $points;
                }

                $answer->update([
                    'is_correct' => $isCorrect,
                ]);
            }

            $score = $totalPoints > 0
                ? round(($earnedPoints / $totalPoints) * 100, 2)
                : 0;

            $lockedAttempt->update([
                'score' => $score,
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            $this->updateRecommendationStatus(
                $lockedAttempt->remedial_recommendation_id,
                'completed'
            );

            return true;
        });

        if (!$result) {
            return back()->with(
                'error',
                'Masih ada soal yang belum dijawab. Lengkapi semua jawaban terlebih dahulu.'
            );
        }

        return redirect()
            ->route('student.remedials.attempts.result', $attempt)
            ->with(
                'success',
                'Latihan berhasil dikumpulkan dan dinilai.'
            );
    }

    /**
     * Menampilkan hasil latihan remediasi.
     */
    public function result(RemedialAttempt $attempt)
    {
        $this->authorizeStudent();

        abort_unless(
            $attempt->student_id === auth()->id(),
            403,
            'Kamu tidak memiliki akses ke hasil latihan ini.'
        );

        abort_unless(
            $attempt->status === 'completed',
            404,
            'Hasil latihan belum tersedia.'
        );

        $attempt->load([
            'material.topic',
            'answers.exercise',
        ]);

        return view(
            'student.remedials.result',
            compact('attempt')
        );
    }
}
