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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('fax', 50)->nullable();
            $table->text('address')->nullable();
            $table->text('google_map')->nullable();
            $table->string('white_logo', 255)->nullable();
            $table->string('dark_logo', 255)->nullable();
            $table->string('fb_link', 500)->nullable();
            $table->string('instagram_link', 500)->nullable();
            $table->string('linkedin_link', 500)->nullable();
            $table->string('twitter_link', 500)->nullable();
            $table->string('youtube_link', 500)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
