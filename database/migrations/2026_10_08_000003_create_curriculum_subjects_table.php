<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // STEP 3 — Subjects: Maths, English, Science
        Schema::create('curriculum_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);                       // Maths
            $table->string('slug', 120)->unique();             // maths
            $table->string('icon', 60)->nullable();            // bootstrap icon name, e.g. calculator
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_subjects');
    }
};
