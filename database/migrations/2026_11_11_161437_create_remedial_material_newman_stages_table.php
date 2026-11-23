<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('remedial_material_newman_stages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('remedial_material_id')
                ->constrained('remedial_materials')
                ->cascadeOnDelete();

            $table->enum('stage', [
                'reading',
                'comprehension',
                'transformation',
                'process_skills',
                'encoding',
            ]);

            $table->timestamps();

            // Mencegah tahap Newman yang sama tercatat
            // lebih dari sekali pada satu materi.
            $table->unique(
                ['remedial_material_id', 'stage'],
                'remedial_material_stage_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remedial_material_newman_stages');
    }
};
