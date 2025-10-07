<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
// (duplicate import removed)

// Home → use Tours archive
Route::get('/', [ListingController::class, 'index'])->name('home');

// Tour Listings & Search
Route::get('/tours', [ListingController::class, 'index'])->name('tours.index');
Route::get('/tours/category/{slug}', [ListingController::class, 'category'])->name('tours.category');
Route::get('/tours/tag/{slug}', [ListingController::class, 'tag'])->name('tours.tag');
Route::get('/tours/search', [ListingController::class, 'search'])->name('tours.search');

// Tour Detail
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');

Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Blog Comments
Route::post('/blog/{post:slug}/comments', [CommentController::class, 'store'])->name('comments.store');

// Pages (placeholders)
Route::get('/pages/{slug}', function ($slug) {
    return view('pages.show', ['slug' => $slug]);
})->name('pages.show');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');
