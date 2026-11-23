<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->unique()->constrained('topics')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('competency')->nullable();
            $table->json('objectives')->nullable();
            $table->longText('content');
            $table->longText('example_content')->nullable();
            $table->longText('practice_prompt')->nullable();
            $table->unsignedSmallInteger('estimated_minutes')->default(15);
            $table->string('status', 20)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_materials');
    }
};
