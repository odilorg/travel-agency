<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\CommentController;

// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Tour Listings & Search
Route::get('/tours/category/{slug}', [ListingController::class, 'category'])->name('tours.category');
Route::get('/tours/tag/{slug}', [ListingController::class, 'tag'])->name('tours.tag');
Route::get('/tours/search', [ListingController::class, 'search'])->name('tours.search');

// Tour Detail
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');

// Blog (placeholders for now)
Route::get('/blog', function () {
    return view('blog.index');
})->name('blog.index');

Route::get('/blog/{slug}', function ($slug) {
    $post = \App\Models\Post::where('slug', $slug)->where('status', 'published')->firstOrFail();
    return view('blog.show', compact('post'));
})->name('blog.show');

// Pages (placeholders)
Route::get('/pages/{slug}', function ($slug) {
    return view('pages.show', ['slug' => $slug]);
})->name('pages.show');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');
