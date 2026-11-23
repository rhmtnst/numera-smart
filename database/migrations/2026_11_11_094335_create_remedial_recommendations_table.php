<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remedial_recommendations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('newman_finding_id')
                ->constrained('newman_findings')
                ->cascadeOnDelete();

            $table->foreignId('remedial_material_id')
                ->constrained('remedial_materials')
                ->cascadeOnDelete();

            $table->foreignId('recommended_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('reason');

            $table->string('status', 20)
                ->default('pending');

            $table->timestamp('recommended_at');

            $table->timestamps();

            $table->unique(
                ['newman_finding_id', 'remedial_material_id'],
                'finding_material_unique'
            );

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remedial_recommendations');
    }
};
