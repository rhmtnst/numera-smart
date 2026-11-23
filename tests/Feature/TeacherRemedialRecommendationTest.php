<?php

namespace Tests\Feature;

use App\Models\AnswerAnalysis;
use App\Models\AssessmentAttempt;
use App\Models\AssessmentTopicReview;
use App\Models\LearningDomain;
use App\Models\NewmanFinding;
use App\Models\Question;
use App\Models\RemedialMaterial;
use App\Models\RemedialRecommendation;
use App\Models\School;
use App\Models\StudentAnswer;
use App\Models\StudentProfile;
use App\Models\TeacherAssignment;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherRemedialRecommendationTest extends TestCase
{
    use RefreshDatabase;

    private User $teacher;
    private User $student;
    private Topic $topic;
    private AssessmentAttempt $attempt;
    private NewmanFinding $finding;
    private School $school;

    /**
     * Siapkan guru, siswa, sekolah, dan penugasan yang valid.
     *
     * TeacherScope memang membatasi rekomendasi berdasarkan sekolah
     * dan kelas yang ditugaskan. Karena itu, fixture test harus memiliki
     * relasi tersebut, bukan hanya membuat user dengan role teacher.
     */
    private function setUpScenario(
        string $stage = 'process_skills',
        string $findingStatus = 'error_indicated',
        string $reviewDecision = 'confirmed'
    ): void {
        $this->school = School::create([
            'name' => 'SD Pengujian',
            'npsn' => '99990001',
            'address' => 'Jalan Pengujian',
            'city' => 'Medan',
            'province' => 'Sumatera Utara',
            'status' => 'active',
        ]);

        $this->teacher = User::create([
            'name' => 'Guru Pengujian',
            'email' => 'guru-test@example.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'school_id' => $this->school->id,
            'is_active' => true,
        ]);

        $this->student = User::create([
            'name' => 'Siswa Pengujian',
            'email' => 'siswa-test@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
            'school_id' => $this->school->id,
            'is_active' => true,
        ]);

        StudentProfile::create([
            'user_id' => $this->student->id,
            'grade_level' => 4,
            'class_name' => null,
        ]);

        TeacherAssignment::create([
            'teacher_id' => $this->teacher->id,
            'school_id' => $this->school->id,
            'grade_level' => 4,
            'class_name' => null,
        ]);

        $domain = LearningDomain::create([
            'name' => 'Numerasi',
            'slug' => 'numerasi-test',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->topic = Topic::create([
            'learning_domain_id' => $domain->id,
            'title' => 'Penjumlahan dan Pengurangan',
            'grade_level' => 4,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Buat soal dan asesmen yang sudah selesai.
        $question = Question::create([
            'topic_id' => $this->topic->id,
            'question_text' => '125 + 75 = ...',
            'question_type' => 'multiple_choice',
            'difficulty' => 'easy',
            'points' => 1,
            'is_active' => true,
            'review_status' => 'approved',
            'source' => 'manual',
            'created_by' => $this->teacher->id,
        ]);

        $this->attempt = AssessmentAttempt::create([
            'student_id' => $this->student->id,
            'topic_id' => $this->topic->id,
            'started_at' => now()->subMinutes(10),
            'completed_at' => now(),
            'status' => 'completed',
            'score' => 0,
        ]);

        $answer = StudentAnswer::create([
            'assessment_attempt_id' => $this->attempt->id,
            'question_id' => $question->id,
            'answer_text' => '200',
            'is_correct' => false,
            'answered_at' => now(),
        ]);

        $analysis = AnswerAnalysis::create([
            'student_answer_id' => $answer->id,
            'analysis_status' => 'completed',
            'analysis_method' => 'rule_based',
            'reviewed_by' => $this->teacher->id,
            'review_decision' => $reviewDecision,
            'teacher_notes' => 'Catatan pengujian guru.',
            'reviewed_at' => now(),
        ]);

        AssessmentTopicReview::create([
            'assessment_attempt_id' => $this->attempt->id,
            'decision' => 'confirmed',
            'teacher_notes' => 'Diagnosis topik telah diperiksa dalam pengujian.',
            'reviewed_by' => $this->teacher->id,
            'reviewed_at' => now(),
        ]);

        $this->finding = NewmanFinding::create([
            'answer_analysis_id' => $analysis->id,
            'stage' => $stage,
            'finding_status' => $findingStatus,
            'evidence' => 'Bukti pengujian.',
            'reason' => 'Alasan pengujian.',
            'teacher_decision' => 'confirmed',
            'teacher_notes' => 'Temuan dikonfirmasi untuk pengujian.',
            'reviewed_by' => $this->teacher->id,
            'reviewed_at' => now(),
        ]);
    }

    private function createMaterial(
        array $stages = ['process_skills'],
        string $status = 'published',
        bool $activeExercise = true
    ): RemedialMaterial {
        $material = RemedialMaterial::create([
            'topic_id' => $this->topic->id,
            'created_by' => $this->teacher->id,
            'title' => 'Materi Pengujian',
            'description' => 'Materi untuk pengujian.',
            'content' => 'Isi materi pengujian.',
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null,
        ]);

        foreach ($stages as $stage) {
            $material->newmanStages()->create([
                'stage' => $stage,
            ]);
        }

        $material->exercises()->create([
            'question_type' => 'multiple_choice',
            'question_text' => 'Hasil 125 + 75 adalah?',
            'options' => ['A' => '100', 'B' => '200'],
            'correct_answer' => 'B',
            'explanation' => '125 + 75 = 200.',
            'points' => 1,
            'sort_order' => 1,
            'is_active' => $activeExercise,
        ]);

        return $material;
    }

    private function submitRecommendation(RemedialMaterial $material)
    {
        return $this->actingAs($this->teacher)->post(
            route('teacher.analyses.recommend', $this->finding),
            [
                'remedial_material_id' => $material->id,
                'reason' => 'Materi sesuai dengan kesulitan siswa.',
            ]
        );
    }

    public function test_recommendation_accepts_matching_newman_stage(): void
    {
        $this->setUpScenario();
        $material = $this->createMaterial();

        $this->submitRecommendation($material)
            ->assertRedirect(route('teacher.analyses.show', $this->attempt->id));

        $this->assertDatabaseHas('remedial_recommendations', [
            'newman_finding_id' => $this->finding->id,
            'remedial_material_id' => $material->id,
        ]);
    }

    public function test_recommendation_allows_system_material_without_creator(): void
    {
        $this->setUpScenario();
        $material = $this->createMaterial();
        $material->update(['created_by' => null]);

        $this->submitRecommendation($material)
            ->assertRedirect(route('teacher.analyses.show', $this->attempt->id));

        $this->assertDatabaseHas('remedial_recommendations', [
            'newman_finding_id' => $this->finding->id,
            'remedial_material_id' => $material->id,
        ]);
    }

    public function test_recommendation_rejects_non_matching_newman_stage(): void
    {
        $this->setUpScenario();
        $material = $this->createMaterial(['encoding']);

        $this->submitRecommendation($material)->assertStatus(422);

        $this->assertDatabaseMissing('remedial_recommendations', [
            'newman_finding_id' => $this->finding->id,
            'remedial_material_id' => $material->id,
        ]);
    }

    public function test_recommendation_rejects_draft_material(): void
    {
        $this->setUpScenario();
        $material = $this->createMaterial(['process_skills'], 'draft');

        $this->submitRecommendation($material)->assertStatus(422);
    }

    public function test_recommendation_rejects_material_without_active_exercise(): void
    {
        $this->setUpScenario();
        $material = $this->createMaterial(['process_skills'], 'published', false);

        $this->submitRecommendation($material)->assertStatus(422);
    }

    public function test_recommendation_rejects_unconfirmed_analysis(): void
    {
        $this->setUpScenario('process_skills', 'error_indicated', 'needs_follow_up');
        $material = $this->createMaterial();

        $this->submitRecommendation($material)->assertStatus(403);
    }

    public function test_recommendation_rejects_finding_without_error_indication(): void
    {
        $this->setUpScenario('process_skills', 'insufficient_evidence', 'confirmed');
        $material = $this->createMaterial();

        $this->submitRecommendation($material)->assertStatus(403);
    }

    public function test_duplicate_recommendation_is_not_created(): void
    {
        $this->setUpScenario();
        $material = $this->createMaterial();

        $this->submitRecommendation($material)->assertRedirect();
        $this->submitRecommendation($material)->assertRedirect();

        $this->assertDatabaseCount('remedial_recommendations', 1);
    }

    public function test_recommendation_rejects_topic_review_needing_revision(): void
    {
        $this->setUpScenario();
        AssessmentTopicReview::where('assessment_attempt_id', $this->attempt->id)
            ->update(['decision' => 'needs_revision']);
        $material = $this->createMaterial();

        $this->submitRecommendation($material)->assertStatus(403);

        $this->assertDatabaseCount('remedial_recommendations', 0);
    }

    public function test_recommendation_rejects_not_confirmed_stage(): void
    {
        $this->setUpScenario();
        $this->finding->update(['teacher_decision' => 'not_confirmed']);
        $material = $this->createMaterial();

        $this->submitRecommendation($material)->assertStatus(403);

        $this->assertDatabaseMissing('remedial_recommendations', [
            'newman_finding_id' => $this->finding->id,
            'remedial_material_id' => $material->id,
        ]);
    }

    public function test_recommendation_rejects_stage_needing_follow_up(): void
    {
        $this->setUpScenario();
        $this->finding->update(['teacher_decision' => 'needs_follow_up']);
        $material = $this->createMaterial();

        $this->submitRecommendation($material)->assertStatus(403);
    }

    public function test_recommendation_rejects_unreviewed_stage(): void
    {
        $this->setUpScenario();
        $this->finding->update([
            'teacher_decision' => null,
            'reviewed_at' => null,
            'reviewed_by' => null,
        ]);
        $material = $this->createMaterial();

        $this->submitRecommendation($material)->assertStatus(403);
    }

    public function test_student_cannot_create_recommendation(): void
    {
        $this->setUpScenario();
        $material = $this->createMaterial();

        $this->actingAs($this->student)
            ->post(route('teacher.analyses.recommend', $this->finding), [
                'remedial_material_id' => $material->id,
                'reason' => 'Materi sesuai dengan kesulitan siswa.',
            ])
            ->assertStatus(403);

        $this->assertDatabaseCount('remedial_recommendations', 0);
    }

    public function test_recommendation_rejects_assessment_without_completed_at(): void
    {
        $this->setUpScenario();
        $this->attempt->update(['completed_at' => null]);
        $material = $this->createMaterial();

        $this->submitRecommendation($material)->assertStatus(404);

        $this->assertDatabaseCount('remedial_recommendations', 0);
    }

    public function test_recommendation_rejects_incomplete_analysis(): void
    {
        $this->setUpScenario();
        $this->finding->answerAnalysis->update(['analysis_status' => 'pending']);
        $material = $this->createMaterial();

        $this->submitRecommendation($material)->assertStatus(403);

        $this->assertDatabaseCount('remedial_recommendations', 0);
    }

    public function test_recommendation_rejects_material_from_different_topic(): void
    {
        $this->setUpScenario();

        $otherTopic = Topic::create([
            'learning_domain_id' => $this->topic->learning_domain_id,
            'title' => 'Perkalian dan Pembagian',
            'grade_level' => 4,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $material = RemedialMaterial::create([
            'topic_id' => $otherTopic->id,
            'created_by' => $this->teacher->id,
            'title' => 'Materi Topik Berbeda',
            'description' => 'Materi pengujian.',
            'content' => 'Isi materi pengujian.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $material->newmanStages()->create(['stage' => 'process_skills']);

        $material->exercises()->create([
            'question_type' => 'multiple_choice',
            'question_text' => 'Hasil 2 x 3 adalah?',
            'options' => ['A' => '5', 'B' => '6'],
            'correct_answer' => 'B',
            'points' => 1,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->submitRecommendation($material)->assertStatus(422);

        $this->assertDatabaseCount('remedial_recommendations', 0);
    }

    public function test_recommendation_rejects_inactive_topic(): void
    {
        $this->setUpScenario();
        $this->topic->update(['is_active' => false]);
        $material = $this->createMaterial();

        $this->submitRecommendation($material)->assertStatus(422);

        $this->assertDatabaseCount('remedial_recommendations', 0);
    }

    public function test_recommendation_rejects_inactive_learning_domain(): void
    {
        $this->setUpScenario();
        $this->topic->learningDomain->update(['is_active' => false]);
        $material = $this->createMaterial();

        $this->submitRecommendation($material)->assertStatus(422);

        $this->assertDatabaseCount('remedial_recommendations', 0);
    }
}
