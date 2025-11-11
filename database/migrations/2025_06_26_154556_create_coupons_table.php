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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();


            $table->string('code', 55);
            $table->text('description')->nullable();
            $table->tinyInteger('discount_type')->default(0)
                ->comment('0-percent, 1-fixed');
            $table->bigInteger('discount_value');
            $table->string('base_currency', 8)->default('GBP');
            $table->integer('usages_limit')->default(1);
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
            $table->tinyInteger('status')->default(1)
                ->comment('0-active, 1-inactive');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
