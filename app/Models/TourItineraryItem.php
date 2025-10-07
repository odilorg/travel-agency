<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourItineraryItem extends Model
{
    protected $fillable = [
        'tour_id',
        'position',
        'day',
        'time',
        'title',
        'title_translations',
        'body_html',
        'body_html_translations',
    ];

    protected $casts = [
        'title_translations' => 'array',
        'body_html_translations' => 'array',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
