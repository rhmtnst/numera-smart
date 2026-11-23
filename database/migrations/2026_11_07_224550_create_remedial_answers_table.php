
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remedial_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('remedial_attempt_id')
                ->constrained('remedial_attempts')
                ->cascadeOnDelete();

            $table->foreignId('remedial_exercise_id')
                ->constrained('remedial_exercises')
                ->cascadeOnDelete();

            $table->text('answer_text')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->timestamp('answered_at')->nullable();

            $table->timestamps();

            $table->unique(
                ['remedial_attempt_id', 'remedial_exercise_id'],
                'remedial_attempt_exercise_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remedial_answers');
    }
};
