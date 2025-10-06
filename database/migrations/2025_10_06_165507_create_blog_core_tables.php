<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('title_translations')->nullable();
            $table->string('slug')->unique();
            $table->string('excerpt', 350)->nullable();
            $table->json('excerpt_translations')->nullable();
            $table->longText('body_html')->nullable();
            $table->json('body_html_translations')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['draft','published','archived'])->default('draft');
            $table->timestamp('published_at')->nullable()->index();
            // SEO
            $table->string('meta_title')->nullable();
            $table->json('meta_title_translations')->nullable();
            $table->string('meta_description', 180)->nullable();
            $table->json('meta_description_translations')->nullable();
            $table->string('canonical_url')->nullable();
            $table->boolean('noindex')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('post_comments')->cascadeOnDelete();
            $table->string('author_name');
            $table->string('author_email');
            $table->text('body');
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });

        Schema::create('category_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->unique(['category_id','post_id']);
        });

        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->unique(['tag_id','post_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('category_post');
        Schema::dropIfExists('post_comments');
        Schema::dropIfExists('posts');
    }
};
