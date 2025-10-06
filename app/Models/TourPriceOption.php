<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TourPriceOption extends Model
{
    use HasTranslations;

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

    public array $translatable = ['name'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
