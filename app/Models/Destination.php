<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Destination extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'country_id',
        'name',
        'slug',
        'excerpt',
        'description_html',
        'video_url',
        'facts',
        'is_featured',
        'order',
        'meta_title',
        'meta_description',
        'canonical_url',
        'noindex',
        'best_time_html',
        'weather_json',
        'travel_tips_html',
        'status',
        'published_at',
    ];

    protected $casts = [
        'facts' => 'array',
        'weather_json' => 'array',
        'noindex' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(DestinationActivity::class)->orderBy('sort_order');
    }

    public function items(): HasMany
    {
        return $this->hasMany(DestinationItem::class)->orderBy('sort_order');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')->singleFile();
        $this->addMediaCollection('gallery');
    }
}
