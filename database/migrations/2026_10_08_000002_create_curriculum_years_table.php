<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // STEP 2 — Year groups inside a phase: Year 1 … Year 6 (Primary), Year 7 … Year 11 (Secondary)
        Schema::create('curriculum_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phase_id')->constrained('curriculum_phases')->cascadeOnDelete();
            $table->string('name', 100);                       // Year 3
            $table->string('slug', 120)->unique();             // year-3
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_years');
    }
};
