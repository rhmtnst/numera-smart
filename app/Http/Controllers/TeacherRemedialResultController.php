<?php

namespace App\Http\Controllers;

use App\Models\RemedialMaterial;
use App\Models\RemedialAttempt;
use App\Models\AssessmentAttempt;
use App\Support\TeacherScope;

class TeacherRemedialResultController extends Controller
{
    /**
     * Memastikan pengguna adalah guru.
     */
    private function authorizeTeacher(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->role === 'teacher',
            403,
            'Halaman ini hanya dapat diakses guru.'
        );
    }

    /**
     * Memastikan guru memiliki akses terhadap materi.
     * Materi bawaan sistem dengan created_by null tetap diperbolehkan.
     */
    private function authorizeMaterial(RemedialMaterial $remedial): void
    {
        $remedial->loadMissing('topic');

        // Guru yang ditugaskan pada topik boleh memantau hasil siswa
        // meskipun materi remedial dibuat oleh guru lain atau admin.
        abort_unless(
            $remedial->topic &&
            TeacherScope::allowsTopic(auth()->user(), $remedial->topic),
            404
        );
    }

    /**
     * Menampilkan daftar hasil remediasi berdasarkan materi.
     */
    public function index(RemedialMaterial $remedial)
    {
        $this->authorizeTeacher();
        $this->authorizeMaterial($remedial);

        $allowedStudentIds = TeacherScope::studentQuery(auth()->user())
            ->select('id');

        $attempts = $remedial->attempts()
            ->whereIn('student_id', $allowedStudentIds)
            ->with('student.studentProfile')
            ->withCount([
                'answers as correct_answers_count' => function ($query) {
                    $query->where('is_correct', true);
                },
                'answers as wrong_answers_count' => function ($query) {
                    $query->where('is_correct', false);
                },
            ])
            ->where('status', 'completed')
            ->latest('completed_at')
            ->paginate(10);

        $totalAttempts = $remedial->attempts()
            ->whereIn('student_id', $allowedStudentIds)
            ->where('status', 'completed')
            ->count();

        $averageScore = $remedial->attempts()
            ->whereIn('student_id', $allowedStudentIds)
            ->where('status', 'completed')
            ->avg('score');

        return view('teacher.remedials.results.index', compact(
            'remedial',
            'attempts',
            'totalAttempts',
            'averageScore'
        ));
    }

    /**
     * Menampilkan detail hasil pengerjaan seorang siswa.
     */
    public function show(
        RemedialMaterial $remedial,
        RemedialAttempt $attempt
    ) {
        $this->authorizeTeacher();
        $this->authorizeMaterial($remedial);

        abort_unless(
            TeacherScope::allowsStudent(
                auth()->user(),
                $attempt->student
            ),
            404
        );

        abort_unless(
            (int) $attempt->remedial_material_id === (int) $remedial->id,
            404
        );

        abort_unless(
            $attempt->status === 'completed',
            404
        );

        $attempt->load([
            'student.studentProfile',
            'material.topic',
            'answers.exercise',
            'recommendation.newmanFinding.answerAnalysis.studentAnswer.assessmentAttempt',
            'recommendation.recommender',
        ]);

        // Prioritaskan asesmen sumber yang benar-benar terhubung melalui rekomendasi.
        $baselineAttempt = $attempt->recommendation?->newmanFinding
            ?->answerAnalysis?->studentAnswer?->assessmentAttempt;

        $baselineSource = $baselineAttempt
            ? 'Asesmen yang menjadi sumber rekomendasi guru'
            : null;

        // Untuk latihan lama yang dimulai dari halaman topik (tanpa recommendation_id),
        // gunakan asesmen terakhir siswa pada topik yang sama sebelum remediasi.
        if (!$baselineAttempt && $attempt->material?->topic_id) {
            $baselineAttempt = AssessmentAttempt::query()
                ->where('student_id', $attempt->student_id)
                ->where('topic_id', $attempt->material->topic_id)
                ->where('status', 'completed')
                ->whereNotNull('completed_at')
                ->when(
                    $attempt->started_at,
                    fn ($query) => $query->where('completed_at', '<=', $attempt->started_at)
                )
                ->latest('completed_at')
                ->first();

            if ($baselineAttempt) {
                $baselineSource = 'Asesmen terakhir pada topik yang sama sebelum remediasi';
            }
        }

        $scoreBefore = $baselineAttempt?->score !== null
            ? (float) $baselineAttempt->score
            : null;
        $scoreAfter = $attempt->score !== null
            ? (float) $attempt->score
            : null;
        $scoreChange = ($scoreBefore !== null && $scoreAfter !== null)
            ? round($scoreAfter - $scoreBefore, 2)
            : null;

        return view(
            'teacher.remedials.results.show',
            compact(
                'remedial',
                'attempt',
                'baselineAttempt',
                'baselineSource',
                'scoreBefore',
                'scoreAfter',
                'scoreChange'
            )
        );
    }
}
