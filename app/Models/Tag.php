<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'name_translations',
    ];

    protected $casts = [
        'name_translations' => 'array',
    ];

    public function tours()
    {
        return $this->morphedByMany(Tour::class, 'taggable');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
