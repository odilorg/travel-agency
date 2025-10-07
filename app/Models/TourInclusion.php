<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourInclusion extends Model
{
    protected $fillable = [
        'tour_id',
        'position',
        'label',
        'label_translations',
    ];

    protected $casts = [
        'label_translations' => 'array',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
