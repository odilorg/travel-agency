<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourHighlight extends Model
{
    use HasTranslations;

    protected $fillable = [
        'tour_id',
        'position',
        'label',
        'label_translations',
    ];

    public array $translatable = ['label'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
