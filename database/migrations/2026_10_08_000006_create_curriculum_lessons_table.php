<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // STEP 6 — Lessons / teaching steps inside a unit: "Hundreds Tens and Ones" (Y3-U01-L01)
        Schema::create('curriculum_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('curriculum_units')->cascadeOnDelete();
            $table->unsignedSmallInteger('lesson_number');     // 1, 2, 3 … inside the unit
            $table->string('code', 30)->unique();              // Y3-U01-L01  (searchable)
            $table->string('title', 200);                      // Hundreds Tens and Ones
            $table->string('slug', 220);
            $table->unsignedSmallInteger('week_number')->nullable();   // Week 1 … 36
            $table->text('objective')->nullable();             // learning objective
            $table->text('summary')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['unit_id', 'lesson_number']);
            $table->index('week_number');
            $table->index('title');                            // fast "search your resources"
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_lessons');
    }
};
