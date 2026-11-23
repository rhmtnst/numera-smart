<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Status pemeriksaan soal
            $table->string('review_status', 30)
                ->default('draft')
                ->index();

            // Sumber pembuatan soal: manual atau AI
            $table->string('source', 20)
                ->default('manual');

            // Guru yang memeriksa soal
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Waktu pemeriksaan soal
            $table->timestamp('reviewed_at')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');

            $table->dropIndex(['review_status']);

            $table->dropColumn([
                'review_status',
                'source',
                'reviewed_at',
            ]);
        });
    }
};
