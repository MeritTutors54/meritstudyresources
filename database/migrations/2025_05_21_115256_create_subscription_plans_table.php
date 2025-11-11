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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)->nullable();
            $table->string('slug', 300)->nullable();
            $table->text('description', 255)->nullable();
            $table->string('stripe_price_id', 255)->nullable();
            $table->decimal('price', 10,2)->nullable();
            $table->tinyInteger('level')->default(0)
                ->comment('0-basic, 1-pro, 2-ultra');
            $table->integer('user_limit')->nullable();
            $table->integer('download_limit')->nullable();
            $table->integer('weekly_limit')->nullable();
            $table->boolean('has_full_access')->default(false);
            $table->integer('trial_days')->nullable();
            $table->tinyInteger('type')->default(0)
                ->comment('0-student, 1-teacher');
            $table->tinyInteger('duration')->default(0)
                ->comment('0-monthly, 1-yearly');
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
        Schema::dropIfExists('subscription_plans');
    }
};
