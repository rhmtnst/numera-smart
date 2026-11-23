
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remedial_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('remedial_material_id')
                ->constrained('remedial_materials')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->string('status', 20)->default('in_progress');
            $table->decimal('score', 8, 2)->nullable();

            $table->timestamps();

            $table->index(['student_id', 'status']);
            $table->index(['remedial_material_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remedial_attempts');
    }
};
