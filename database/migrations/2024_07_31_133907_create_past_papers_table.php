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
        Schema::create('past_papers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('uploads_type', 50)->nullable();
            $table->unsignedBigInteger('category')->nullable();
            $table->unsignedBigInteger('subcategory')->nullable();
            $table->unsignedBigInteger('resubcategory')->nullable();
            $table->unsignedBigInteger('exam_series')->nullable();
            $table->string('option_code', 50)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->integer('price')->nullable();
            $table->string('currency', 50)->default('GBP');
            $table->text('ques_paper', 255)->nullable();
            $table->text('ans_paper', 255)->nullable();
            $table->boolean('have_solution')->default(false);
            $table->tinyInteger('is_active')->default(1);
            $table->boolean('is_deleted')->default(false);
            $table->text('details')->nullable();
            $table->boolean("have_video_solution")->default(false);
            $table->boolean('have_pdf_solution')->default(false);
            $table->tinyInteger('video_procedure')->default(0);
            $table->text('video_link')->nullable();
            $table->text('pdf_solution')->nullable();
            $table->text('video_solution')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('past_papers');
    }
};
