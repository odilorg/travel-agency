<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tour extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'title','title_translations','slug','excerpt','excerpt_translations',
        'description_html','description_html_translations','duration_days','duration_nights',
        'price_from','currency','city_id','difficulty','is_featured','status','published_at',
        'latitude','longitude','avg_rating','reviews_count','meta_title','meta_title_translations',
        'meta_description','meta_description_translations','canonical_url','noindex','notranslate',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'noindex' => 'boolean',
        'notranslate' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'title_translations' => 'array',
        'excerpt_translations' => 'array',
        'description_html_translations' => 'array',
        'meta_title_translations' => 'array',
        'meta_description_translations' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(80)
            ->doNotGenerateSlugsOnUpdate();
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function itineraryItems()
    {
        return $this->hasMany(TourItineraryItem::class)->orderBy('position');
    }

    public function faqs()
    {
        return $this->hasMany(TourFaq::class)->orderBy('position');
    }

    public function priceOptions()
    {
        return $this->hasMany(TourPriceOption::class)->orderBy('position');
    }

    public function extras()
    {
        return $this->hasMany(TourExtra::class)->orderBy('position');
    }

    public function highlights()
    {
        return $this->hasMany(TourHighlight::class)->orderBy('position');
    }

    public function inclusions()
    {
        return $this->hasMany(TourInclusion::class)->orderBy('position');
    }

    public function exclusions()
    {
        return $this->hasMany(TourExclusion::class)->orderBy('position');
    }

    public function reviews()
    {
        return $this->hasMany(TourReview::class)->latest();
    }
}
