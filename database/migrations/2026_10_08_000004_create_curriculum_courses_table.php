<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // STEP 4 — A course = one year + one subject  →  "Year 3 Maths"
        Schema::create('curriculum_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained('curriculum_years')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('curriculum_subjects')->cascadeOnDelete();
            $table->string('title', 150);                      // Year 3 Maths
            $table->string('slug', 170)->unique();             // year-3-maths
            $table->string('curriculum_label', 100)->default('England National Curriculum');
            $table->text('intro')->nullable();                 // "Find a topic, open a teaching step…"
            $table->unsignedSmallInteger('planned_weeks')->default(36);
            $table->boolean('has_weekly_homework')->default(true);
            $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['year_id', 'subject_id']);        // only one Year 3 Maths
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_courses');
    }
};
