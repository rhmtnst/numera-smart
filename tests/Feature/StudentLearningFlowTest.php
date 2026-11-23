<?php

namespace Tests\Feature;

use App\Models\LearningDomain;
use App\Models\LearningMaterial;
use App\Models\School;
use App\Models\StudentProfile;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentLearningFlowTest extends TestCase
{
    use RefreshDatabase;

    private function student(int $grade = 4): User
    {
        $school = School::create(['name' => 'SD Uji', 'status' => 'active']);
        $student = User::create(['name' => 'Siswa Uji', 'email' => 'student'.$grade.'@test.local', 'password' => 'password123', 'role' => 'student', 'school_id' => $school->id, 'is_active' => true]);
        StudentProfile::create(['user_id' => $student->id, 'grade_level' => $grade]);
        return $student;
    }

    public function test_student_dashboard_shows_grade_topics_even_before_assessment_questions_are_approved(): void
    {
        $student = $this->student(4);
        $domain = LearningDomain::create(['name' => 'Operasi Hitung', 'slug' => 'operasi-hitung', 'is_active' => true, 'sort_order' => 1]);
        Topic::create(['learning_domain_id' => $domain->id, 'title' => 'Penjumlahan dan Pengurangan', 'grade_level' => 4, 'is_active' => true]);

        $this->actingAs($student)->get(route('student.dashboard'))
            ->assertOk()->assertSee('Operasi Hitung')->assertSee('Pilih Dunia Pembelajaran');
    }

    public function test_student_can_open_published_learning_material_without_approved_questions(): void
    {
        $student = $this->student(4);
        $domain = LearningDomain::create(['name' => 'Operasi Hitung', 'slug' => 'operasi-hitung', 'is_active' => true, 'sort_order' => 1]);
        $topic = Topic::create(['learning_domain_id' => $domain->id, 'title' => 'Penjumlahan', 'grade_level' => 4, 'is_active' => true]);
        LearningMaterial::create(['topic_id' => $topic->id, 'title' => 'Belajar Penjumlahan', 'objectives' => ['Menjumlahkan bilangan'], 'content' => 'Penjumlahan menggabungkan dua kelompok.', 'status' => 'published', 'published_at' => now()]);

        $this->actingAs($student)->get(route('student.topics.show', $topic))
            ->assertOk()->assertSee('Materi Pembelajaran')->assertSee('Penjumlahan menggabungkan dua kelompok.');
    }

    public function test_student_cannot_open_topic_for_another_grade(): void
    {
        $student = $this->student(4);
        $domain = LearningDomain::create(['name' => 'Pengukuran', 'slug' => 'pengukuran', 'is_active' => true, 'sort_order' => 1]);
        $topic = Topic::create(['learning_domain_id' => $domain->id, 'title' => 'Pengukuran kelas V', 'grade_level' => 5, 'is_active' => true]);

        $this->actingAs($student)->get(route('student.topics.show', $topic))->assertNotFound();
    }
}
