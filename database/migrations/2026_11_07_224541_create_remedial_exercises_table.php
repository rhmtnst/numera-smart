
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remedial_exercises', function (Blueprint $table) {
            $table->id();

            $table->foreignId('remedial_material_id')
                ->constrained('remedial_materials')
                ->cascadeOnDelete();

            $table->string('question_type', 30)->default('multiple_choice');
            $table->text('question_text');
            $table->json('options')->nullable();
            $table->string('correct_answer')->nullable();
            $table->text('explanation')->nullable();

            $table->unsignedInteger('points')->default(1);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['remedial_material_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remedial_exercises');
    }
};
