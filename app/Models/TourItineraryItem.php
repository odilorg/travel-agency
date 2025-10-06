<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourItineraryItem extends Model
{
    use HasTranslations;

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

    public array $translatable = ['title','body_html'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
