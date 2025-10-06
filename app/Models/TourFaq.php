<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourFaq extends Model
{
    use HasTranslations;

    protected $fillable = [
        'tour_id',
        'position',
        'question',
        'question_translations',
        'answer_html',
        'answer_html_translations',
    ];

    public array $translatable = ['question','answer_html'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
