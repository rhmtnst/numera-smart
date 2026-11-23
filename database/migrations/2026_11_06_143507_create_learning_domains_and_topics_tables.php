
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_domains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('topics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('learning_domain_id')
                ->constrained('learning_domains')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('grade_level');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(
                ['learning_domain_id', 'grade_level', 'title'],
                'topics_domain_grade_title_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
        Schema::dropIfExists('learning_domains');
    }
};
