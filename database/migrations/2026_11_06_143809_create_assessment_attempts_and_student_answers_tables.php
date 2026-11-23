
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();

            $table->string('status', 20)->default('in_progress');

            $table->decimal('score', 6, 2)->nullable();

            $table->timestamps();

            $table->index(['student_id', 'status']);
        });

        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assessment_attempt_id')
                ->constrained('assessment_attempts')
                ->cascadeOnDelete();

            $table->foreignId('question_id')
                ->constrained('questions')
                ->restrictOnDelete();

            $table->text('answer_text')->nullable();

            $table->longText('working_steps')->nullable();

            $table->text('student_explanation')->nullable();

            $table->boolean('is_correct')->nullable();

            $table->timestamp('answered_at')->nullable();

            $table->timestamps();

            $table->unique(
                ['assessment_attempt_id', 'question_id'],
                'attempt_question_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_answers');
        Schema::dropIfExists('assessment_attempts');
    }
};
