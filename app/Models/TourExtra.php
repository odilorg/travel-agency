<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourExtra extends Model
{
    use HasTranslations;

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

    public array $translatable = ['label','description'];

    protected $casts = [
        'per_person' => 'boolean',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
