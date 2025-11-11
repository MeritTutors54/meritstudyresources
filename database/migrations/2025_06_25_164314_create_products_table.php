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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('book_variant_id')->nullable();
            $table->foreign('book_variant_id')->references('id')->on('book_variants');

            $table->string('name', 255)->nullable();
            $table->string('slug', 300)->nullable();
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->bigInteger('regular_price');
            $table->bigInteger('discount_price')->nullable();
            $table->string('base_currency', 8)->default('GBP');

            $table->text('search_text')->nullable();

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
        Schema::dropIfExists('products');
    }
};
