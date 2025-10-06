<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_itinerary_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(1);
            $table->unsignedSmallInteger('day')->nullable();
            $table->string('time')->nullable();
            $table->string('title')->nullable();
            $table->json('title_translations')->nullable();
            $table->longText('body_html')->nullable();
            $table->json('body_html_translations')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(1);
            $table->string('question');
            $table->json('question_translations')->nullable();
            $table->longText('answer_html')->nullable();
            $table->json('answer_html_translations')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_price_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(1);
            $table->string('name');
            $table->json('name_translations')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->char('currency', 3)->default('USD');
            $table->unsignedSmallInteger('min_pax')->nullable();
            $table->unsignedSmallInteger('max_pax')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('tour_extras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(1);
            $table->string('label');
            $table->json('label_translations')->nullable();
            $table->text('description')->nullable();
            $table->json('description_translations')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('per_person')->default(false);
            $table->timestamps();
        });

        Schema::create('tour_highlights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(1);
            $table->string('label');
            $table->json('label_translations')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_inclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(1);
            $table->string('label');
            $table->json('label_translations')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_exclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(1);
            $table->string('label');
            $table->json('label_translations')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->string('author_name');
            $table->string('author_email');
            $table->unsignedTinyInteger('rating');
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->boolean('verified_booking')->default(false);
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_reviews');
        Schema::dropIfExists('tour_exclusions');
        Schema::dropIfExists('tour_inclusions');
        Schema::dropIfExists('tour_highlights');
        Schema::dropIfExists('tour_extras');
        Schema::dropIfExists('tour_price_options');
        Schema::dropIfExists('tour_faqs');
        Schema::dropIfExists('tour_itinerary_items');
    }
};
