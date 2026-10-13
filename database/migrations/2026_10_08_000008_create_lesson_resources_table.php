<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // STEP 8 — The actual files for each lesson (one row per file)
        Schema::create('lesson_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('curriculum_lessons')->cascadeOnDelete();
            $table->foreignId('resource_type_id')->constrained('lesson_resource_types');
            $table->string('title', 200);                      // Lesson plan — Hundreds Tens and Ones
            $table->string('file_path', 500);                  // public disk: teacher-library/year-3-maths/Y3-U01-L01/slides.pptx
            $table->string('file_ext', 10)->nullable();        // pdf, pptx, docx
            $table->unsignedBigInteger('file_size')->nullable();       // bytes
            $table->boolean('is_paid')->default(true);                 // same rule as merit_resources.is_paid — false = free for everyone
            $table->boolean('is_pro')->default(false);                 // same as board_resource_files.is_pro — needs a Pro plan
            $table->unsignedInteger('download_count')->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['lesson_id', 'resource_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_resources');
    }
};
