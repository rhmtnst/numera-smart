<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\StudentProfile;
use App\Models\TeacherAssignment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherAssignmentScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_only_sees_students_in_assigned_school_and_grade(): void
    {
        $school = School::create(['name' => 'SD Uji', 'status' => 'active']);
        $teacher = User::create(['name' => 'Guru IV', 'email' => 'guru@test.local', 'password' => 'password123', 'role' => 'teacher', 'school_id' => $school->id, 'is_active' => true]);
        TeacherAssignment::create(['teacher_id' => $teacher->id, 'school_id' => $school->id, 'grade_level' => 4]);

        $gradeFour = User::create(['name' => 'Budi Kelas IV', 'email' => 'budi@test.local', 'password' => 'password123', 'role' => 'student', 'school_id' => $school->id, 'is_active' => true]);
        StudentProfile::create(['user_id' => $gradeFour->id, 'grade_level' => 4]);
        $gradeFive = User::create(['name' => 'Rina Kelas V', 'email' => 'rina@test.local', 'password' => 'password123', 'role' => 'student', 'school_id' => $school->id, 'is_active' => true]);
        StudentProfile::create(['user_id' => $gradeFive->id, 'grade_level' => 5]);

        $this->actingAs($teacher)->get(route('teacher.students.index'))
            ->assertOk()->assertSee('Budi Kelas IV')->assertDontSee('Rina Kelas V');
    }

    public function test_teacher_without_assignments_sees_no_students(): void
    {
        $teacher = User::create(['name' => 'Guru Kosong', 'email' => 'kosong@test.local', 'password' => 'password123', 'role' => 'teacher', 'is_active' => true]);
        $this->actingAs($teacher)->get(route('teacher.students.index'))
            ->assertOk()->assertSee('Belum ada siswa pada kelas yang ditugaskan.');
    }
}
