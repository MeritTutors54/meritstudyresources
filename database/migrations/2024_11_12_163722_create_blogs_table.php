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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->string('title', 255)->nullable();
            $table->string('slug', 300)->nullable();

            $table->unsignedBigInteger('blog_category_id')->nullable();
            $table->foreign('blog_category_id')->references('id')->on('blog_categories');

            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('admins');

            $table->text('description')->nullable();

            $table->longText('details')->nullable();
            $table->tinyInteger('status')->default(1)
                ->comment('0=inactive, 1=active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
