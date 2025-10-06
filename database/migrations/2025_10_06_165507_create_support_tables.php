<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('from')->unique();
            $table->string('to');
            $table->unsignedSmallInteger('http_status')->default(301);
            $table->timestamps();
        });

        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->json('site_name_translations')->nullable();
            $table->string('brand_logo_path')->nullable();
            $table->json('social_links')->nullable();
            $table->json('default_meta')->nullable();
            $table->string('default_locale')->default('en');
            $table->string('contact_email')->nullable();
            $table->string('recaptcha_site_key')->nullable();
            $table->string('recaptcha_secret_key')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('contact_submissions');
        Schema::dropIfExists('redirects');
    }
};
