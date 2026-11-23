<?php

namespace App\Http\Controllers;

use App\Models\RemedialMaterial;
use App\Models\RemedialRecommendation;
use Illuminate\Http\Request;

class StudentRemedialController extends Controller
{
    private function authorizeStudent(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->role === 'student',
            403,
            'Halaman ini hanya dapat diakses siswa.'
        );
    }

    /**
     * Menampilkan materi remediasi.
     */
    public function show(Request $request, RemedialMaterial $remedial)
    {
        $this->authorizeStudent();

        $student = auth()->user();
        $profile = $student->studentProfile;

        abort_if(!$profile, 403, 'Profil siswa belum tersedia.');

        // Pastikan materi sudah dipublikasikan.
        abort_unless(
            $remedial->status === 'published',
            404
        );

        // Pastikan materi sesuai kelas siswa.
        abort_unless(
            $remedial->topic->grade_level == $profile->grade_level &&
            $remedial->topic->is_active &&
            $remedial->topic->learningDomain->is_active,
            404
        );

        // Ambil rekomendasi jika siswa membuka materi dari dashboard.
        $recommendation = null;

        if ($request->filled('recommendation_id')) {
            $recommendation = RemedialRecommendation::query()
                ->whereKey($request->query('recommendation_id'))
                ->where('remedial_material_id', $remedial->id)
                ->whereHas('newmanFinding', function ($query) {
                    $query->where('finding_status', 'error_indicated')
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
                      $query->where('student_id', $student->id)
    ->where('status', 'completed')
    ->whereNotNull('completed_at');
                    }
                )
                ->firstOrFail();
        }

        // Ambil soal latihan yang aktif.
        $remedial->load([
            'topic',
            'exercises' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('sort_order');
            }
        ]);

        abort_if($remedial->exercises->isEmpty(), 404);

        return view('student.remedials.show', [
            'material' => $remedial,
            'recommendation' => $recommendation,
        ]);
    }
}
