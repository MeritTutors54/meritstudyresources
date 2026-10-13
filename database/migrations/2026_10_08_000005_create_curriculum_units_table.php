<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // STEP 5 — Units / topics in teaching order: Place Value, Addition and Subtraction…
        Schema::create('curriculum_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('curriculum_courses')->cascadeOnDelete();
            $table->unsignedSmallInteger('unit_number');       // 1, 2, 3 … (the teaching sequence)
            $table->string('title', 150);                      // Place Value
            $table->string('slug', 170);                       // place-value
            $table->text('summary')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['course_id', 'unit_number']);
            $table->unique(['course_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_units');
    }
};
