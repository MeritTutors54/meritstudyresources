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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('site_logo')->after('dark_logo')->nullable();
            $table->string('site_favicon')->after('dark_logo')->nullable();


            $table->dropColumn(['fb_link', 'instagram_link', 'linkedin_link', 'twitter_link', 'youtube_link']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Rollback: add dropped columns back
            $table->string('fb_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('youtube_link')->nullable();

            // Remove newly added columns
            $table->dropColumn(['site_logo', 'site_favicon']);
        });
    }
};
