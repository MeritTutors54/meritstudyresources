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
        Schema::create('admin_activity_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('action');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();

            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_activity_logs');
    }
};
