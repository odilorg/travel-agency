<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourFaq extends Model
{
    protected $fillable = [
        'tour_id',
        'position',
        'question',
        'question_translations',
        'answer_html',
        'answer_html_translations',
    ];

    protected $casts = [
        'question_translations' => 'array',
        'answer_html_translations' => 'array',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
