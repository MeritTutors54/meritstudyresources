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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('invoice_number', 255)->nullable();

            $table->string('billing_name', 255)->nullable();
            $table->string('billing_phone', 55)->nullable();
            $table->string('billing_alternative_phone', 55)->nullable();
            $table->text('billing_address', 255)->nullable();
            $table->string('billing_city', 255)->nullable();
            $table->string('billing_state', 255)->nullable();
            $table->string('billing_post_code', 55)->nullable();
            $table->text('remarks')->nullable();

            $table->string('coupon_code', 255)->nullable();
            $table->string('base_currency', 8)->default('GBP');
            $table->bigInteger('total_price');
            $table->bigInteger('discount_price')->nullable();
            $table->bigInteger('subtotal_price');
            $table->bigInteger('delivery_cost');

            $table->string('tracking_number', 255)->nullable();
            $table->string('stripe_charge_id', 255)->nullable();
            $table->string('stripe_refund_id', 255)->nullable();

            $table->tinyInteger('status')->default(0)
                ->comment('0-incomplete_payment, 1-confirmed_payment');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
