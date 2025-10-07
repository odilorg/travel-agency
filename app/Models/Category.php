<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'name_translations',
        'description',
        'description_translations',
    ];

    protected $casts = [
        'name_translations' => 'array',
        'description_translations' => 'array',
    ];

    public function tours()
    {
        return $this->belongsToMany(Tour::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
