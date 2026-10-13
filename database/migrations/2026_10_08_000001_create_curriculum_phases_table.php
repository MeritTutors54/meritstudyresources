<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // STEP 1 — School phases: Primary, Secondary
        Schema::create('curriculum_phases', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);                       // Primary
            $table->string('slug', 120)->unique();             // primary
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_phases');
    }
};
