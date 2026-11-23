<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_topic_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_attempt_id')->unique()->constrained('assessment_attempts')->cascadeOnDelete();
            $table->string('decision', 30)->nullable();
            $table->text('teacher_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_topic_reviews');
    }
};
