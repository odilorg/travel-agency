<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourExtra extends Model
{
    protected $fillable = [
        'tour_id',
        'position',
        'label',
        'label_translations',
        'description',
        'description_translations',
        'price',
        'per_person',
    ];

    protected $casts = [
        'per_person' => 'boolean',
        'label_translations' => 'array',
        'description_translations' => 'array',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
