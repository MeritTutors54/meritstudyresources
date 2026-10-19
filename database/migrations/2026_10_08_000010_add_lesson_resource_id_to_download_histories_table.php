<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * STEP 10 — Log teacher library downloads in the EXISTING download_histories table.
 *
 * Why: User::getRemainingDownloadsAttribute() counts rows in download_histories for the
 * school and all its teachers. Logging lesson downloads here means they count towards
 * the same subscription download limit, and show up in the dashboard download history.
 *
 * A lesson download row has:
 *   resource_id        = NULL         (that column points to merit_resources)
 *   lesson_resource_id = lesson_resources.id
 *   type               = ResourceType::LESSON (6)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('download_histories', function (Blueprint $table) {
            $table->foreignId('lesson_resource_id')
                ->nullable()
                ->after('resource_id')
                ->constrained('lesson_resources')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('download_histories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('lesson_resource_id');
        });
    }
};
