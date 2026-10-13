<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // STEP 7 — Kinds of file a lesson can have: Lesson plan, Slides, Classwork, Answers, Homework
        Schema::create('lesson_resource_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);                       // Slides
            $table->string('slug', 120)->unique();             // slides
            $table->string('icon', 60)->nullable();            // easel
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_resource_types');
    }
};
