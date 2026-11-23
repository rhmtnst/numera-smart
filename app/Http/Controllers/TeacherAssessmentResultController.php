<?php

namespace App\Http\Controllers;

use App\Models\AssessmentAttempt;
use App\Support\TeacherScope;

class TeacherAssessmentResultController extends Controller
{
    /**
     * Memastikan hanya guru yang dapat mengakses halaman.
     */
    private function authorizeTeacher(): void
    {
        abort_unless(
            auth()->user()->role === 'teacher',
            403,
            'Halaman ini hanya dapat diakses guru.'
        );
    }

    /**
     * Menampilkan daftar hasil asesmen siswa.
     */
    public function index()
    {
        $this->authorizeTeacher();

        $attempts = TeacherScope::attemptQuery(auth()->user())->with([
            'student.studentProfile',
            'topic',
        ])
        ->withCount('answers')
        ->where('status', 'completed')
        ->latest('completed_at')
        ->paginate(10);

        return view(
            'teacher.results.index',
            compact('attempts')
        );
    }

    /**
     * Menampilkan detail pengerjaan asesmen siswa.
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
        ]);

        return view(
            'teacher.results.show',
            compact('attempt')
        );
    }
}