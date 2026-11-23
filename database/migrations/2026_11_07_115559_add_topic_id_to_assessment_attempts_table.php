<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessment_attempts', function (Blueprint $table) {
            $table->foreignId('topic_id')
                ->nullable()
                ->after('student_id')
                ->constrained('topics')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('assessment_attempts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('topic_id');
        });
    }
};