<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;

Route::get('/', function () {
    return view('welcome');
});

// Tour Listings & Search
Route::get('/tours/category/{slug}', [ListingController::class, 'category'])->name('tours.category');
Route::get('/tours/tag/{slug}', [ListingController::class, 'tag'])->name('tours.tag');
Route::get('/tours/search', [ListingController::class, 'search'])->name('tours.search');

// Tour Detail (placeholder for future implementation)
Route::get('/tours/{slug}', function ($slug) {
    $tour = \App\Models\Tour::where('slug', $slug)->where('status', 'published')->firstOrFail();
    return view('tours.show', compact('tour'));
})->name('tours.show');
