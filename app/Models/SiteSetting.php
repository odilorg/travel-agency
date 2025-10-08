<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        // Brand & Global
        'site_name',
        'site_name_translations',
        'brand_logo_path',
        'brand_logo_footer_url',
        'main_language',
        'default_locale',
        'default_currency',
        'topbar_currency_selector_enabled',
        'topbar_language_selector_enabled',
        
        // Contact Info
        'company_name',
        'contact_email',
        'contact_phone',
        'contact_address_line',
        'contact_address_city',
        'contact_address_country',
        'contact_blurb',
        
        // Social Media
        'social_links', // Legacy field
        'social_facebook_url',
        'social_instagram_url',
        'social_x_url',
        'social_youtube_url',
        'show_social_in_header',
        'show_social_in_footer',
        
        // Footer
        'footer_copyright',
        'footer_payment_badge_url',
        'footer_top_destinations',
        'footer_information_links',
        
        // Map
        'map_iframe_src',
        
        // Contact Form
        'contact_send_to_email',
        'contact_send_cc',
        'contact_send_bcc',
        'contact_auto_reply_enabled',
        'contact_auto_reply_subject',
        'contact_auto_reply_body',
        
        // SEO & Security
        'default_meta',
        'recaptcha_site_key',
        'recaptcha_secret_key',
    ];

    protected $casts = [
        'site_name_translations' => 'array',
        'social_links' => 'array',
        'default_meta' => 'array',
        'footer_top_destinations' => 'array',
        'footer_information_links' => 'array',
        'topbar_currency_selector_enabled' => 'boolean',
        'topbar_language_selector_enabled' => 'boolean',
        'show_social_in_header' => 'boolean',
        'show_social_in_footer' => 'boolean',
        'contact_auto_reply_enabled' => 'boolean',
    ];

    /**
     * Get the singleton instance (first or create)
     */
    public static function getInstance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
