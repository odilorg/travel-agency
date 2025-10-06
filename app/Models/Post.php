<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use SoftDeletes, HasTranslations, HasSlug;

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

    public array $translatable = [
        'title',
        'excerpt',
        'body_html',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'noindex' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(80)
            ->doNotGenerateSlugsOnUpdate();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }
}
