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
        Schema::create('subject_topic_lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_topic_id')
                ->constrained('subject_topics')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('video_url')->nullable();
            $table->string('video_type')->nullable(); // youtube, upload
            $table->integer('duration')->nullable(); // in minutes
            $table->string('notes_pdf')->nullable();
            $table->boolean('is_preview')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index('subject_topic_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_topic_lectures');
    }
};
