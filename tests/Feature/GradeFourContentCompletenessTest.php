<?php

namespace Tests\Feature;

use App\Models\LearningMaterial;
use App\Models\Question;
use App\Models\RemedialExercise;
use App\Models\RemedialMaterial;
use App\Models\Topic;
use App\Models\VerificationQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GradeFourContentCompletenessTest extends TestCase
{
    use RefreshDatabase;

    public function test_grade_four_has_twelve_topics_and_published_learning_materials(): void
    {
        $this->seed();

        $topics = Topic::where('grade_level', 4)->get();

        $this->assertCount(12, $topics);
        $this->assertSame(12, LearningMaterial::whereIn('topic_id', $topics->pluck('id'))
            ->where('status', 'published')->count());
    }

    public function test_every_grade_four_topic_has_ten_reviewable_assessment_questions(): void
    {
        $this->seed();

        $topics = Topic::where('grade_level', 4)->get();

        $this->assertSame(120, Question::whereIn('topic_id', $topics->pluck('id'))->count());
        $this->assertSame(120, Question::whereIn('topic_id', $topics->pluck('id'))
            ->where('review_status', 'draft')->count());
    }

    public function test_every_grade_four_topic_has_newman_remediation_and_verification_content(): void
    {
        $this->seed();

        $topics = Topic::where('grade_level', 4)->get();
        $materials = RemedialMaterial::whereIn('topic_id', $topics->pluck('id'))->get();

        $this->assertCount(12, $materials);
        $this->assertSame(60, RemedialExercise::whereIn('remedial_material_id', $materials->pluck('id'))->count());
        $this->assertSame(60, VerificationQuestion::whereIn('topic_id', $topics->pluck('id'))
            ->where('is_active', true)->count());

        $expectedStages = ['reading', 'comprehension', 'transformation', 'process_skills', 'encoding'];
        foreach ($topics as $topic) {
            $this->assertEqualsCanonicalizing(
                $expectedStages,
                VerificationQuestion::where('topic_id', $topic->id)
                    ->where('is_active', true)
                    ->pluck('target_stage')
                    ->all()
            );
        }

        foreach ($materials as $material) {
            $this->assertSame(5, $material->newmanStages()->count());
            $this->assertSame(5, $material->exercises()->count());
            $this->assertSame('draft', $material->status);
        }
    }
}
