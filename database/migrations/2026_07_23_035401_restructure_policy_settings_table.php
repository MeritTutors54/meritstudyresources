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
        Schema::table('policy_settings', function (Blueprint $table) {
            $table->dropColumn(['key', 'value']);

            $table->tinyInteger('policy')->comment("1=privacy, 2=terms, 3=return, 4=refund")->after('id');
            $table->text('description')->nullable()->after('id');
            $table->string('title')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('policy_settings', function (Blueprint $table) {
            // 1. Drop the new columns
            $table->dropColumn(['title', 'description', 'policy']);

            // 2. Restore the original columns
            $table->string('key')->after('id');
            $table->text('value')->nullable()->after('key');
        });
    }
};
