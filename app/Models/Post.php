<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

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
     * Get the featured image URL (placeholder for now)
     */
    public function getFeaturedImageAttribute(): ?string
    {
        // This could be from Spatie Media Library or a dedicated column
        // For now, return a placeholder
        return asset('assets/images/blogs/placeholder.jpg');
    }
}
