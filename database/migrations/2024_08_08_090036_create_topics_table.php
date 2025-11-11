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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('education_level_id')->nullable();
            $table->foreign('education_level_id')->references('id')->on('education_levels');

            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects');

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('topics');

            $table->unsignedBigInteger('topic_group_id')->nullable();
            $table->foreign('topic_group_id')->references('id')->on('topic_groups');

            $table->string('title', 255);
            $table->string('slug', 300);
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)
                ->comment('0 - Inactive, 1 - Active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
