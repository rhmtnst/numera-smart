
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('topic_id')
                ->constrained('topics')
                ->restrictOnDelete();

            $table->text('question_text');
            $table->text('stimulus')->nullable();

            $table->string('question_type', 30);
            $table->text('correct_answer')->nullable();
            $table->text('explanation')->nullable();

            $table->string('difficulty', 20)->default('medium');
            $table->unsignedSmallInteger('points')->default(10);

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        Schema::create('question_options', function (Blueprint $table) {
            $table->id();

            $table->foreignId('question_id')
                ->constrained('questions')
                ->cascadeOnDelete();

            $table->string('option_label', 5);
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->unique(['question_id', 'option_label']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('questions');
    }
};
