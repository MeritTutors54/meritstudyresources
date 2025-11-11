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
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
            $table->string('page_title', 255)->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_author')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('google_verification')->nullable();
            $table->text('bing_verification')->nullable();
            $table->text('google_analytics')->nullable();
            $table->text('alexa_analytics')->nullable();
            $table->text('facebook_pixel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seos');
    }
};
