<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('newman_findings', function (Blueprint $table) {
            $table->string('teacher_decision', 30)->nullable();

            $table->text('teacher_notes')->nullable();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('newman_findings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');

            $table->dropColumn([
                'teacher_decision',
                'teacher_notes',
                'reviewed_at',
            ]);
        });
    }
};
