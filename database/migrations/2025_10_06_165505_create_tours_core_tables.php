<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('title_translations')->nullable();
            $table->string('slug')->unique();
            $table->string('excerpt', 350)->nullable();
            $table->json('excerpt_translations')->nullable();
            $table->longText('description_html')->nullable();
            $table->json('description_html_translations')->nullable();
            $table->unsignedTinyInteger('duration_days')->nullable();
            $table->unsignedTinyInteger('duration_nights')->nullable();
            $table->decimal('price_from', 10, 2)->nullable();
            $table->char('currency', 3)->nullable()->default('USD');
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('difficulty', ['easy','moderate','hard'])->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft','published','archived'])->default('draft');
            $table->timestamp('published_at')->nullable()->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedTinyInteger('avg_rating')->nullable();
            $table->unsignedInteger('reviews_count')->default(0);
            // SEO
            $table->string('meta_title')->nullable();
            $table->json('meta_title_translations')->nullable();
            $table->string('meta_description', 180)->nullable();
            $table->json('meta_description_translations')->nullable();
            $table->string('canonical_url')->nullable();
            $table->boolean('noindex')->default(false);
            $table->boolean('notranslate')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('category_tour', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->unique(['category_id','tour_id']);
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->morphs('taggable');
            $table->unique(['tag_id','taggable_id','taggable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('category_tour');
        Schema::dropIfExists('tours');
    }
};
