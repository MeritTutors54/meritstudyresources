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
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('blog_id')->nullable();
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('admins');

            $table->unsignedBigInteger('replied_by')->nullable();
            $table->foreign('replied_by')->references('id')->on('admins');

            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->longText('comment')->nullable();
            $table->longText('reply_comment')->nullable();

            $table->tinyInteger('status')->default(0)
                ->comment('0 = pending, 1 = approved, -1 = rejected');

            $table->timestamp('reply_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_comments');
    }
};
