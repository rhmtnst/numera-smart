<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Topic;
use App\Models\AssessmentAttempt;
use App\Models\School;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalSchools' => School::count(),
            'totalTeachers' => User::where('role', 'teacher')->count(),
            'totalStudents' => User::where('role', 'student')->count(),
            'totalTopics' => Topic::count(),
            'totalAssessments' => AssessmentAttempt::where('status', 'completed')->count(),
        ]);
    }
}
