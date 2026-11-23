<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\RemedialExercise;
use App\Models\RemedialMaterial;
use App\Models\Topic;
use App\Models\VerificationQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GradeFiveSixContentCompletenessTest extends TestCase
{
    use RefreshDatabase;

    public function test_grade_five_and_six_have_complete_assessment_remedial_and_newman_content(): void
    {
        $this->seed();

        foreach ([5, 6] as $grade) {
            $topics = Topic::where('grade_level', $grade)->get();
            $this->assertCount(12, $topics, "Kelas {$grade} harus memiliki 12 topik.");

            $topicIds = $topics->pluck('id');
            $this->assertSame(120, Question::whereIn('topic_id', $topicIds)->count(), "Kelas {$grade} harus memiliki 120 soal asesmen.");

            $materials = RemedialMaterial::whereIn('topic_id', $topicIds)->get();
            $this->assertCount(12, $materials, "Kelas {$grade} harus memiliki 12 materi remediasi.");
            $this->assertSame(60, RemedialExercise::whereIn('remedial_material_id', $materials->pluck('id'))->count(), "Kelas {$grade} harus memiliki 60 latihan remediasi.");
            $this->assertSame(60, VerificationQuestion::whereIn('topic_id', $topicIds)
                ->where('is_active', true)->count(), "Kelas {$grade} harus memiliki 60 pertanyaan verifikasi aktif.");

            $expectedStages = ['reading', 'comprehension', 'transformation', 'process_skills', 'encoding'];
            foreach ($topics as $topic) {
                $this->assertEqualsCanonicalizing(
                    $expectedStages,
                    VerificationQuestion::where('topic_id', $topic->id)
                        ->where('is_active', true)
                        ->pluck('target_stage')
                        ->all(),
                    "Topik {$topic->title} harus memiliki pertanyaan aktif untuk lima tahap Newman."
                );
                $this->assertSame(10, $topic->questions()->count(), "Topik {$topic->title} harus memiliki 10 soal.");
                $material = $materials->firstWhere('topic_id', $topic->id);
                $this->assertNotNull($material);
                $this->assertSame(5, $material->exercises()->count());
                $this->assertSame(5, $material->newmanStages()->count());
                $this->assertSame('draft', $material->status);
            }
        }
    }
}
