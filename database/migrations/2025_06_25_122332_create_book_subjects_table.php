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
        Schema::create('book_subjects', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('book_category_id')->nullable();
            $table->foreign('book_category_id')->references('id')->on('book_categories');

            $table->string('name', 255)->nullable();
            $table->string('slug', 300)->nullable();
            $table->text('description')->nullable();

            $table->tinyInteger('status')->default(1)
                ->comment('0-inactive, 1-active');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_subjects');
    }
};
