<?php

namespace App\Http\Controllers;

use App\Models\LearningDomain;
use App\Models\RemedialRecommendation;
use App\Models\AssessmentAttempt;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user();

        abort_unless($student->role === 'student', 403);

        $profile = $student->studentProfile;

        abort_unless($profile, 404, 'Profil siswa belum tersedia.');

        // Mengambil domain dan topik sesuai kelas siswa.
        $domains = LearningDomain::query()
            ->where('is_active', true)
            ->with(['topics' => function ($query) use ($profile) {
                $query->where('grade_level', $profile->grade_level)
                    ->where('is_active', true)
                    ->with([
                        'learningMaterial' => fn ($material) =>
                            $material->where('status', 'published')
                    ])
                    ->withCount([
                        'questions as available_questions_count' => fn ($questions) =>
                            $questions->where('is_active', true)
                                ->where('review_status', 'approved')
                    ])
                    ->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        $topicIds = $domains
            ->flatMap(fn ($domain) => $domain->topics->pluck('id'))
            ->values();

        $completedTopicIds = $student->assessmentAttempts()
            ->where('status', 'completed')
            ->whereNotNull('completed_at')
            ->whereNotNull('topic_id')
            ->pluck('topic_id')
            ->unique()
            ->intersect($topicIds)
            ->values();

        // Rekomendasi remedial yang telah dikonfirmasi guru.
        $remedialRecommendations = RemedialRecommendation::query()
            ->with(['remedialMaterial.topic', 'newmanFinding'])
            ->whereHas('newmanFinding', fn ($finding) =>
                $finding->where('finding_status', 'error_indicated')
                    ->whereNotNull('reviewed_at')
                    ->where('teacher_decision', 'confirmed')
                    ->whereHas('answerAnalysis', fn ($analysis) =>
                        $analysis->whereNotNull('reviewed_at')
                            ->where('review_decision', 'confirmed')
                    )
            )
            ->whereHas(
                'newmanFinding.answerAnalysis.studentAnswer.assessmentAttempt',
                fn ($attempt) =>
                    $attempt->where('student_id', $student->id)
                        ->where('status', 'completed')
                        ->whereNotNull('completed_at')
            )
            ->whereHas('remedialMaterial', fn ($material) =>
                $material->where('status', 'published')
                    ->whereHas('topic', fn ($topic) =>
                        $topic->where('grade_level', $profile->grade_level)
                            ->where('is_active', true)
                    )
                    ->whereHas('exercises', fn ($exercise) =>
                        $exercise->where('is_active', true)
                    )
            )
            ->latest('recommended_at')
            ->get();

        // Menghitung progres belajar siswa.
        $totalMissions = $topicIds->count();
        $completedMissions = $completedTopicIds->count();

        $progressPercentage = $totalMissions > 0
            ? round(($completedMissions / $totalMissions) * 100)
            : 0;

        // Riwayat asesmen beserta analisis Newman.
        $recentAttempts = AssessmentAttempt::with([
            'topic.learningDomain',
            'topicReview',
            'answers.analysis.newmanFindings',
        ])
            ->where('student_id', $student->id)
            ->where('status', 'completed')
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->take(8)
            ->get();

        // Topik yang memiliki soal asesmen tersedia.
        $availableAssessmentTopics = $domains->flatMap(
            fn ($domain) => $domain->topics->filter(
                fn ($topic) => $topic->available_questions_count > 0
            )
        );

        $completedAssessmentCount = $student->assessmentAttempts()
            ->where('status', 'completed')
            ->count();

        return view('student.dashboard', compact(
            'student',
            'profile',
            'domains',
            'totalMissions',
            'completedMissions',
            'progressPercentage',
            'completedTopicIds',
            'remedialRecommendations',
            'recentAttempts',
            'availableAssessmentTopics',
            'completedAssessmentCount'
        ));
    }
}
