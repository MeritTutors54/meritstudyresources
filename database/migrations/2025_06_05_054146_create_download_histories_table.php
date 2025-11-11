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
        Schema::create('download_histories', function (Blueprint $table) {
            $table->id();

            $table->uuid('request_id')->unique();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('resource_id')->nullable();
            $table->foreign('resource_id')->references('id')->on('merit_resources');

            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->foreign('subscription_id')->references('id')->on('subscriptions');

            $table->tinyInteger('type')->comment('see the resource type enum');
            $table->string('fingerprint')->nullable();
            $table->string('ip_address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('download_histories');
    }
};
