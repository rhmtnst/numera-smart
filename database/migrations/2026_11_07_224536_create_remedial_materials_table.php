
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remedial_materials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('topic_id')
                ->constrained('topics')
                ->cascadeOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content');
            $table->longText('example_content')->nullable();

            $table->string('status', 20)->default('draft');
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index(['topic_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remedial_materials');
    }
};
