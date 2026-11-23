<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan hubungan antara percobaan
     * remediasi dan rekomendasi guru.
     */
    public function up(): void
    {
        Schema::table('remedial_attempts', function (Blueprint $table) {
            $table->foreignId('remedial_recommendation_id')
                ->nullable()
                ->after('remedial_material_id')
                ->constrained('remedial_recommendations')
                ->nullOnDelete();
        });
    }

    /**
     * Mengembalikan perubahan migration.
     */
    public function down(): void
    {
        Schema::table('remedial_attempts', function (Blueprint $table) {
            $table->dropConstrainedForeignId(
                'remedial_recommendation_id'
            );
        });
    }
};
