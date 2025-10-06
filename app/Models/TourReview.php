<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourReview extends Model
{
    protected $fillable = [
        'tour_id',
        'author_name',
        'author_email',
        'rating',
        'title',
        'body',
        'verified_booking',
        'approved',
    ];

    protected $casts = [
        'verified_booking' => 'boolean',
        'approved' => 'boolean',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
