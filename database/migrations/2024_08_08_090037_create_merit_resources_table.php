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
        Schema::create('merit_resources', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)->nullable();
            $table->string('slug', 300)->nullable();

            $table->unsignedBigInteger('topic_id')->nullable();
            $table->foreign('topic_id')->references('id')->on('topics');

            $table->string('search_text', 1500)->nullable();

            $table->boolean('is_paid')->default(false);
            $table->string('thumbnail_image', 200)->nullable();
            $table->string('main_pdf', 200)->nullable();
            $table->text('description')->nullable();

            $table->tinyInteger('status')->default(1)
                ->comment('0-inactive, 1-active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merit_resources');
    }
};
