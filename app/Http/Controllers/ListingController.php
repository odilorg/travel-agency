<?php

namespace App\Http\Controllers;

use App\Models\{Tour, Category, Tag, City};
use App\Services\{MetaService, SchemaService};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
    public function category(string $slug, Request $request, MetaService $meta, SchemaService $schema)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $query = Tour::with(['city', 'categories', 'tags'])
            ->where('status', 'published')
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id));

        $query = $this->applyFilters($query, $request);
        $tours = $query->paginate(12)->withQueryString();

        $metaData = $meta->compose(
            title: $category->name.' Tours — '.config('app.name'),
            description: Str::limit(strip_tags($category->description ?? 'Browse tours'), 160)
        );

        $collectionSchema = $this->collectionPageSchema($schema, "Tours in {$category->name}", route('tours.category', $slug));

        return view('tours.listing', compact('tours', 'metaData', 'category', 'collectionSchema'));
    }

    public function tag(string $slug, Request $request, MetaService $meta, SchemaService $schema)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $query = Tour::with(['city', 'categories', 'tags'])
            ->where('status', 'published')
            ->whereHas('tags', fn($q) => $q->where('tags.id', $tag->id));

        $query = $this->applyFilters($query, $request);
        $tours = $query->paginate(12)->withQueryString();

        $metaData = $meta->compose(
            title: 'Tours — '.$tag->name.' — '.config('app.name'),
            description: 'Browse tours tagged '.$tag->name
        );

        $collectionSchema = $this->collectionPageSchema($schema, "Tours tagged {$tag->name}", route('tours.tag', $slug));

        return view('tours.listing', compact('tours', 'metaData', 'tag', 'collectionSchema'));
    }

    public function search(Request $request, MetaService $meta, SchemaService $schema)
    {
        $q = trim((string) $request->get('q', ''));
        $query = Tour::with(['city', 'categories', 'tags'])->where('status', 'published');

        if ($q !== '') {
            // Prefer FULLTEXT where available; fallback to LIKE.
            $driver = DB::getDriverName();
            if ($driver === 'mysql') {
                $query->where(function (Builder $sub) use ($q) {
                    $sub->whereRaw('MATCH (title, excerpt, description_html) AGAINST (? IN BOOLEAN MODE)', [$this->toBooleanQuery($q)])
                        ->orWhere('title', 'LIKE', "%{$q}%")
                        ->orWhere('excerpt', 'LIKE', "%{$q}%");
                });
            } else {
                $query->where(function (Builder $sub) use ($q) {
                    $sub->where('title', 'LIKE', "%{$q}%")
                        ->orWhere('excerpt', 'LIKE', "%{$q}%");
                });
            }
        }

        $query = $this->applyFilters($query, $request);
        $tours = $query->paginate(12)->withQueryString();

        $pageTitle = $q ? "Search: \"{$q}\" — ".config('app.name') : 'Search Tours — '.config('app.name');
        $metaData = $meta->compose(title: $pageTitle, description: 'Search results');

        $collectionSchema = $this->collectionPageSchema($schema, "Search results for {$q}", route('tours.search').'?q='.urlencode($q));

        return view('tours.search', compact('tours', 'metaData', 'q', 'collectionSchema'));
    }

    // ---- Helpers ----

    protected function toBooleanQuery(string $q): string
    {
        // Basic boolean mode expansion: prefix words with +, ignore short tokens.
        $terms = collect(preg_split('/\s+/', $q))
            ->filter(fn($t) => mb_strlen($t) >= 2)
            ->map(fn($t) => '+'.Str::lower($t).'*');
        return $terms->join(' ');
    }

    protected function applyFilters(Builder $query, Request $request): Builder
    {
        if ($city = $request->get('city')) {
            $query->whereHas('city', fn($q) => $q->where('slug', $city));
        }
        if ($cat = $request->get('category')) {
            $query->whereHas('categories', fn($q) => $q->where('slug', $cat));
        }
        if ($tag = $request->get('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $tag));
        }
        if ($min = $request->get('min_price')) {
            $query->where('price_from', '>=', (float)$min);
        }
        if ($max = $request->get('max_price')) {
            $query->where('price_from', '<=', (float)$max);
        }
        if ($dmin = $request->get('min_days')) {
            $query->where('duration_days', '>=', (int)$dmin);
        }
        if ($dmax = $request->get('max_days')) {
            $query->where('duration_days', '<=', (int)$dmax);
        }
        return $query;
    }

    protected function collectionPageSchema(SchemaService $schema, string $name, string $url): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $name,
            'mainEntityOfPage' => $url,
        ];
    }
}

