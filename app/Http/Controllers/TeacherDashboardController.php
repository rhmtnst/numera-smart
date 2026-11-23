<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use App\Support\TeacherScope;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        // Batasi akses hanya untuk guru
        if (auth()->user()->role !== 'teacher') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Statistik bank soal
        $grades = TeacherScope::gradeLevels(auth()->user());
        $questionScope = Question::whereHas('topic', fn ($query) => $query->whereIn('grade_level', $grades))
            ->where(fn ($query) => $query->whereNull('created_by')->orWhere('created_by', auth()->id()));
        $totalQuestions = (clone $questionScope)->count();
        $draftQuestions = (clone $questionScope)->whereIn('review_status', ['draft', 'revision_requested'])->count();
        $approvedQuestions = (clone $questionScope)->where('review_status', 'approved')->count();
        $totalStudents = TeacherScope::studentQuery(auth()->user())->count();
        $recentDraftQuestions = (clone $questionScope)->with('topic')->whereIn('review_status', ['draft', 'revision_requested'])->latest()->take(5)->get();

        return view('teacher.dashboard', compact(
            'totalQuestions',
            'draftQuestions',
            'approvedQuestions',
            'totalStudents',
            'recentDraftQuestions'
        ));
    }
}
