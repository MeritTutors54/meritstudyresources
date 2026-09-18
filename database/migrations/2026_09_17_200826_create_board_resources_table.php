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
        Schema::create('board_resources', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resubcategory_id')->constrained('resubcategories')->cascadeOnDelete();
            $table->tinyInteger('resource_type')->default(3);
            $table->foreignId('parent_id')->nullable()->constrained('board_resources')->cascadeOnDelete();

            $table->string('name')->nullable();

            $table->boolean('is_group')->default(false);
            $table->boolean('is_section_title')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_active')->default(1);

            $table->timestamps();
        });

        Schema::create('board_resource_files', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger('type')->default(1)->comment('1 = straight, 2 = difficulty');
            $table->foreignId('board_resource_id')->constrained('board_resources')->cascadeOnDelete();
            $table->string('difficulty')->nullable(); // 'Medium', 'Hard'
            $table->boolean('is_pro')->default(false);
            $table->string('file_path');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('board_resources');
        Schema::dropIfExists('board_resource_files');

        Schema::enableForeignKeyConstraints();
    }
};
