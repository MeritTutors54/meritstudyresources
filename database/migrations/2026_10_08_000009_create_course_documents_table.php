<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // STEP 9 — Course-level files: Curriculum map, Weekly planning, Term assessments
        Schema::create('course_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('curriculum_courses')->cascadeOnDelete();
            $table->enum('type', ['curriculum_map', 'weekly_planning', 'term_assessment']);
            $table->enum('term', ['autumn', 'spring', 'summer'])->nullable();   // for assessments
            $table->string('title', 200);
            $table->string('file_path', 500);
            $table->string('file_ext', 10)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_documents');
    }
};
