<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourPriceOption extends Model
{
    protected $fillable = [
        'tour_id',
        'position',
        'name',
        'name_translations',
        'price',
        'currency',
        'min_pax',
        'max_pax',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'name_translations' => 'array',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
