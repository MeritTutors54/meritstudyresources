<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('name', 'title');

            $table->unsignedBigInteger('year_group_id')->after('title')->nullable();
            $table->foreign('year_group_id')->references('id')->on('year_groups');

            $table->decimal('discount_percentage')->after('discount_price')->nullable();

            $table->string('sku')->unique()->nullable()->after('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['year_group_id']);

            $table->dropColumn([
                'year_group_id',
                'discount_percentage',
                'sku',
            ]);

            $table->renameColumn('title', 'name');
        });
    }
};
