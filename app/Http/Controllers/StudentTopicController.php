<?php

namespace App\Http\Controllers;

use App\Models\LearningDomain;
use App\Models\Topic;

class StudentTopicController extends Controller
{
    private function studentProfile()
    {
        abort_unless(auth()->user()?->role === 'student', 403, 'Halaman ini hanya dapat diakses siswa.');
        $profile = auth()->user()->studentProfile;
        abort_if(!$profile, 403, 'Profil siswa belum tersedia.');
        return $profile;
    }

    public function index(LearningDomain $domain)
    {
        $profile = $this->studentProfile();
        abort_unless($domain->is_active, 404);

        $topics = $domain->topics()
            ->where('grade_level', $profile->grade_level)
            ->where('is_active', true)
            ->with(['learningMaterial' => fn ($query) => $query->where('status', 'published')])
            ->withCount(['questions as available_questions_count' => fn ($query) => $query->where('is_active', true)->where('review_status', 'approved')])
            ->orderBy('sort_order')->get();

        return view('student.topics.index', compact('domain', 'topics'));
    }

    public function show(Topic $topic)
    {
        $profile = $this->studentProfile();
        abort_unless((int) $topic->grade_level === (int) $profile->grade_level && $topic->is_active && $topic->learningDomain?->is_active, 404);

        $topic->loadCount(['questions as available_questions_count' => fn ($query) => $query->where('is_active', true)->where('review_status', 'approved')]);
        $topic->load([
            'learningMaterial' => fn ($query) => $query->where('status', 'published'),
            'remedialMaterials' => fn ($query) => $query->where('status', 'published')->withCount(['exercises as active_exercises_count' => fn ($exercise) => $exercise->where('is_active', true)])->orderByDesc('published_at'),
        ]);

        return view('student.topics.show', compact('topic'));
    }
}
