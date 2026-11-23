
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Hasil analisis untuk setiap jawaban siswa
        Schema::create('answer_analyses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_answer_id')
                ->unique()
                ->constrained('student_answers')
                ->cascadeOnDelete();

            $table->string('analysis_status', 30)
                ->default('pending');

            $table->string('analysis_method', 20)
                ->default('rule_based');

            $table->text('analysis_summary')->nullable();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('review_decision', 20)->nullable();
            $table->text('teacher_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->index('analysis_status');
        });

        // 2. Indikasi kesulitan berdasarkan lima tahap Newman
        Schema::create('newman_findings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('answer_analysis_id')
                ->constrained('answer_analyses')
                ->cascadeOnDelete();

            $table->string('stage', 30);

            $table->string('finding_status', 30)
                ->default('insufficient_evidence');

            $table->text('evidence')->nullable();
            $table->text('reason')->nullable();

            $table->timestamps();

            $table->unique(
                ['answer_analysis_id', 'stage'],
                'analysis_stage_unique'
            );
        });

        // 3. Bank pertanyaan verifikasi
        Schema::create('verification_questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('topic_id')
                ->nullable()
                ->constrained('topics')
                ->nullOnDelete();

            $table->string('target_stage', 30);
            $table->text('question_text');

            $table->string('response_type', 20)
                ->default('text');

            $table->json('options')->nullable();
            $table->text('interpretation_guide')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['target_stage', 'is_active']);
        });

        // 4. Respons siswa terhadap pertanyaan verifikasi
        Schema::create('verification_responses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('answer_analysis_id')
                ->constrained('answer_analyses')
                ->cascadeOnDelete();

            $table->foreignId('verification_question_id')
                ->constrained('verification_questions')
                ->restrictOnDelete();

            $table->text('response_text')->nullable();

            $table->timestamp('asked_at')->nullable();
            $table->timestamp('answered_at')->nullable();

            $table->timestamps();

            $table->index('answer_analysis_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_responses');
        Schema::dropIfExists('verification_questions');
        Schema::dropIfExists('newman_findings');
        Schema::dropIfExists('answer_analyses');
    }
};
