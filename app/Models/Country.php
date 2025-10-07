<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'iso2',
        'meta_title',
        'meta_description',
    ];

    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }
}
