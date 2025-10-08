<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Hero Section
            $table->string('about_hero_bg_image')->nullable()->after('contact_auto_reply_body');
            $table->string('about_hero_title')->nullable()->after('about_hero_bg_image');
            $table->string('about_hero_subtitle')->nullable()->after('about_hero_title');
            $table->string('about_hero_video_url')->nullable()->after('about_hero_subtitle');

            // Provide Best Travel Experience Section
            $table->string('about_provide_title')->nullable()->after('about_hero_video_url');
            $table->text('about_provide_text')->nullable()->after('about_provide_title');

            // Vision & Mission
            $table->string('about_vision_title')->default('Our Vision')->after('about_provide_text');
            $table->text('about_vision_text')->nullable()->after('about_vision_title');
            $table->string('about_vision_icon')->nullable()->after('about_vision_text');
            $table->string('about_mission_title')->default('Our Mission')->after('about_vision_icon');
            $table->text('about_mission_text')->nullable()->after('about_mission_title');
            $table->string('about_mission_icon')->nullable()->after('about_mission_text');

            // Dream Destination Section
            $table->string('about_dream_title')->nullable()->after('about_mission_icon');
            $table->text('about_dream_text')->nullable()->after('about_dream_title');
            $table->json('about_dream_features')->nullable()->after('about_dream_text');

            // Enjoy Exclusive Section
            $table->string('about_enjoy_title')->nullable()->after('about_dream_features');
            $table->text('about_enjoy_text')->nullable()->after('about_enjoy_title');
            $table->string('about_enjoy_image')->nullable()->after('about_enjoy_text');

            // Team Section
            $table->json('about_team_members')->nullable()->after('about_enjoy_image');

            // Contact Tiles
            $table->string('about_contact_email_label')->default('Email')->after('about_team_members');
            $table->string('about_contact_email')->nullable()->after('about_contact_email_label');
            $table->string('about_contact_phone_label')->default('Phone')->after('about_contact_email');
            $table->string('about_contact_phone')->nullable()->after('about_contact_phone_label');
            $table->string('about_contact_location_label')->default('Location')->after('about_contact_phone');
            $table->string('about_contact_location')->nullable()->after('about_contact_location_label');
            $table->string('about_contact_location_map_url')->nullable()->after('about_contact_location');

            // CTA Form Section
            $table->string('about_cta_title')->nullable()->after('about_contact_location_map_url');
            $table->text('about_cta_text')->nullable()->after('about_cta_title');
            $table->boolean('about_cta_enabled')->default(true)->after('about_cta_text');
            $table->boolean('about_cta_uses_contact_form')->default(true)->after('about_cta_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'about_hero_bg_image',
                'about_hero_title',
                'about_hero_subtitle',
                'about_hero_video_url',
                'about_provide_title',
                'about_provide_text',
                'about_vision_title',
                'about_vision_text',
                'about_vision_icon',
                'about_mission_title',
                'about_mission_text',
                'about_mission_icon',
                'about_dream_title',
                'about_dream_text',
                'about_dream_features',
                'about_enjoy_title',
                'about_enjoy_text',
                'about_enjoy_image',
                'about_team_members',
                'about_contact_email_label',
                'about_contact_email',
                'about_contact_phone_label',
                'about_contact_phone',
                'about_contact_location_label',
                'about_contact_location',
                'about_contact_location_map_url',
                'about_cta_title',
                'about_cta_text',
                'about_cta_enabled',
                'about_cta_uses_contact_form',
            ]);
        });
    }
};

