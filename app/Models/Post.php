<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title',
        'title_translations',
        'slug',
        'excerpt',
        'excerpt_translations',
        'body_html',
        'body_html_translations',
        'author_id',
        'status',
        'published_at',
        'meta_title',
        'meta_title_translations',
        'meta_description',
        'meta_description_translations',
        'canonical_url',
        'noindex',
        'featured_alt',
        'featured_credit',
        'featured_caption',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'noindex' => 'boolean',
        'title_translations' => 'array',
        'excerpt_translations' => 'array',
        'body_html_translations' => 'array',
        'meta_title_translations' => 'array',
        'meta_description_translations' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    /**
     * Get the estimated read time in minutes
     */
    public function getReadTimeAttribute(): ?int
    {
        if (!$this->body_html) {
            return null;
        }

        // Average reading speed is 200-250 words per minute
        $wordCount = str_word_count(strip_tags($this->body_html));
        $minutes = ceil($wordCount / 200);

        return max(1, $minutes); // Minimum 1 minute
    }

    /**
     * Register media collections for posts
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')->useDisk('public');
    }

    /**
     * Register media conversions
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(400)->height(300)->nonQueued();
        $this->addMediaConversion('wide')->width(1200)->height(675)->nonQueued();
    }

    /**
     * Get the featured image URL with fallback
     */
    public function getFeaturedImageAttribute(): ?string
    {
        if (method_exists($this, 'hasMedia') && $this->hasMedia('featured')) {
            return $this->getFirstMediaUrl('featured', 'wide') ?: $this->getFirstMediaUrl('featured');
        }
        return asset('assets/images/blogs/details-01.png');
    }
}
