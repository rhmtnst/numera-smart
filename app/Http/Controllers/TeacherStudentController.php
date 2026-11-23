<?php

namespace App\Http\Controllers;

use App\Support\TeacherScope;

class TeacherStudentController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()?->role === 'teacher', 403);

        $students = TeacherScope::studentQuery(auth()->user())
            ->with('studentProfile', 'school')
            ->orderBy('name')
            ->paginate(15);

        $assignments = TeacherScope::assignments(auth()->user());

        return view('teacher.students.index', compact('students', 'assignments'));
    }
}
