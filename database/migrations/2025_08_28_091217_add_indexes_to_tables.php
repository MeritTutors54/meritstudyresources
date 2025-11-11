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
        Schema::table('admins', function (Blueprint $table) {
            $table->index(['team_id', 'email', 'created_at', 'created_by']);
        });

        Schema::table('admin_activity_logs', function (Blueprint $table) {
            $table->index(['admin_id', 'model_id']);
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->index(['blog_category_id', 'author_id', 'created_at']);
        });

        Schema::table('blog_categories', function (Blueprint $table) {
            $table->index('slug');
        });

        Schema::table('blog_comments', function (Blueprint $table) {
            $table->index(['blog_id', 'user_id', 'created_at']);
        });

        Schema::table('blog_images', function (Blueprint $table) {
            $table->index(['blog_id', 'created_at']);
        });

        Schema::table('blog_tags', function (Blueprint $table) {
            $table->index(['blog_id', 'tag_id']);
        });

        Schema::table('blog_views', function (Blueprint $table) {
            $table->index(['blog_id', 'user_id', 'ip_address']);
        });

        Schema::table('book_categories', function (Blueprint $table) {
            $table->index(['slug', 'created_at']);
        });

        Schema::table('book_subjects', function (Blueprint $table) {
            $table->index(['book_category_id', 'slug', 'created_at']);
        });

        Schema::table('book_variants', function (Blueprint $table) {
            $table->index(
                ['book_category_id', 'book_subject_id', 'slug', 'created_at'],
                'book_variants_idx'
            );
        });

        ###################

        Schema::table('categories', function (Blueprint $table) {
            $table->index(['slug', 'created_at']);
        });

        Schema::table('education_levels', function (Blueprint $table) {
            $table->index(['slug', 'created_at']);
        });

        Schema::table('merit_resources', function (Blueprint $table) {
            $table->index(['slug', 'created_at']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index(['user_id', 'invoice_number', 'created_at']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->index(['order_id', 'product_id']);
        });

        Schema::table('past_papers', function (Blueprint $table) {
            $table->index(
                ['category', 'exam_series', 'subcategory', 'resubcategory', 'created_at'],
                'past_papers_idx'
            );
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index(['book_variant_id', 'slug', 'created_at']);
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->index(['product_id', 'created_at']);
        });

        Schema::table('resource_images', function (Blueprint $table) {
            $table->index(['resource_id', 'topic_id', 'created_at']);
        });

        Schema::table('resubcategories', function (Blueprint $table) {
            $table->index(['category_id', 'subcategory_id', 'created_at']);
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->index(['category_id', 'created_at']);
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->index(['slug', 'created_at']);
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->index(
                ['education_level_id', 'subject_id', 'parent_id', 'topic_group_id', 'slug', 'created_at'],
            'topics_idx'
            );
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index(['team_id', 'email', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('admins', function (Blueprint $table) {
            $table->dropIndex(['team_id', 'email', 'created_at', 'created_by']);
        });

        Schema::table('admin_activity_logs', function (Blueprint $table) {
            $table->dropIndex(['admin_id', 'model_id']);
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropIndex(['blog_category_id', 'author_id', 'created_at']);
        });

        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropIndex(['slug']);
        });

        Schema::table('blog_comments', function (Blueprint $table) {
            $table->dropIndex(['blog_id', 'user_id', 'created_at']);
        });

        Schema::table('blog_images', function (Blueprint $table) {
            $table->dropIndex(['blog_id', 'created_at']);
        });

        Schema::table('blog_tags', function (Blueprint $table) {
            $table->dropIndex(['blog_id', 'tag_id']);
        });

        Schema::table('blog_views', function (Blueprint $table) {
            $table->dropIndex(['blog_id', 'user_id', 'ip_address']);
        });

        Schema::table('book_categories', function (Blueprint $table) {
            $table->dropIndex(['slug', 'created_at']);
        });

        Schema::table('book_subjects', function (Blueprint $table) {
            $table->dropIndex(['book_category_id', 'slug', 'created_at']);
        });

        Schema::table('book_variants', function (Blueprint $table) {
            $table->dropIndex('book_variants_idx');
        });


        ###################

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['slug', 'created_at']);
        });

        Schema::table('education_levels', function (Blueprint $table) {
            $table->dropIndex(['slug', 'created_at']);
        });

        Schema::table('merit_resources', function (Blueprint $table) {
            $table->dropIndex(['slug', 'created_at']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'invoice_number', 'created_at']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex(['order_id', 'product_id']);
        });

        Schema::table('past_papers', function (Blueprint $table) {
            $table->dropIndex('past_papers_idx');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['book_variant_id', 'slug', 'created_at']);
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->dropIndex(['product_id', 'created_at']);
        });

        Schema::table('resource_images', function (Blueprint $table) {
            $table->dropIndex(['resource_id', 'topic_id', 'created_at']);
        });

        Schema::table('resubcategories', function (Blueprint $table) {
            $table->dropIndex(['category_id', 'subcategory_id', 'created_at']);
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropIndex(['category_id', 'created_at']);
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropIndex(['slug', 'created_at']);
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->dropIndex('topics_idx');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['team_id', 'email', 'created_at']);
        });
    }
};
