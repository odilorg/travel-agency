<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Services\MetaService;
use App\Services\SchemaService;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function __construct(
        protected MetaService $metaService,
        protected SchemaService $schemaService
    ) {}

    /**
     * Display the specified tour.
     */
    public function show(string $slug)
    {
        $tour = Tour::with([
            'city',
            'categories',
            'tags',
            'itineraryItems' => fn($q) => $q->orderBy('position'),
            'faqs' => fn($q) => $q->orderBy('position'),
            'highlights' => fn($q) => $q->orderBy('position'),
            'inclusions' => fn($q) => $q->orderBy('position'),
            'exclusions' => fn($q) => $q->orderBy('position'),
            'extras' => fn($q) => $q->orderBy('position'),
            'priceOptions' => fn($q) => $q->orderBy('position'),
            'reviews' => fn($q) => $q->where('approved', true)->latest()->limit(20),
        ])
        ->withCount(['reviews' => fn($q) => $q->where('approved', true)])
        ->withAvg(['reviews' => fn($q) => $q->where('approved', true)], 'rating')
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

        // Load media (Spatie Media Library)
        if (method_exists($tour, 'getMedia')) {
            $tour->load('media');
        }

        // Generate meta data for SEO
        $metaData = $this->metaService->forTour($tour);

        // Generate JSON-LD structured data
        $jsonLd = $this->schemaService->tourDetail($tour);

        // Get related tours (same city or same categories)
        $relatedTours = Tour::where('id', '!=', $tour->id)
            ->where('status', 'published')
            ->where(function($query) use ($tour) {
                $query->where('city_id', $tour->city_id)
                    ->orWhereHas('categories', function($q) use ($tour) {
                        $q->whereIn('categories.id', $tour->categories->pluck('id'));
                    });
            })
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('tours.show', compact('tour', 'metaData', 'jsonLd', 'relatedTours'));
    }
}

