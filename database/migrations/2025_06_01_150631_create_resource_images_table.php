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
        Schema::create('resource_images', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('resource_id')->nullable();
            $table->foreign('resource_id')->references('id')->on('merit_resources');

            $table->unsignedBigInteger('topic_id')->nullable();
            $table->foreign('topic_id')->references('id')->on('topics');

            $table->string('image_path')->nullable();
            $table->tinyInteger('status')->default(1)
                ->comment('0-inactive, 1-active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_images');
    }
};
