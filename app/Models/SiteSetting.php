<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_name_translations',
        'brand_logo_path',
        'social_links',
        'default_meta',
        'default_locale',
        'contact_email',
        'recaptcha_site_key',
        'recaptcha_secret_key',
    ];

    protected $casts = [
        'social_links' => 'array',
        'default_meta' => 'array',
        'site_name_translations' => 'array',
    ];
}
