<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'country_code',
        'name_translations',
    ];

    protected $casts = [
        'name_translations' => 'array',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }
}
