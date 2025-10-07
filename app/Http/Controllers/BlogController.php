<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\MetaService;
use App\Services\SchemaService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Blog index (archive) with basic filtering and pagination
     */
    public function index(Request $request)
    {
        $query = Post::query()
            ->with(['author','categories','tags','media'])
            ->where('status','published');

        if ($cat = $request->get('category')) {
            $query->whereHas('categories', fn($q) => $q->where('slug',$cat));
        }
        if ($tag = $request->get('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('slug',$tag));
        }
        if ($q = trim((string)$request->get('q',''))) {
            $query->where(function($sub) use ($q){
                $sub->where('title','like','%'.$q.'%')
                    ->orWhere('excerpt','like','%'.$q.'%')
                    ->orWhere('body_html','like','%'.$q.'%');
            });
        }

        $sort = (string)$request->get('sort','new');
        match ($sort) {
            'popular' => $query->orderByDesc('published_at')->orderByDesc('id'),
            default => $query->orderByDesc('published_at'),
        };

        $posts = $query->paginate(9)->withQueryString();

        $metaData = $this->metaService->compose(title: 'Blog — '.config('app.name'));

        return view('blog.index', compact('posts','metaData'));
    }
    public function __construct(
        protected MetaService $metaService,
        protected SchemaService $schemaService
    ) {}

    /**
     * Display the specified blog post.
     */
    public function show(string $slug)
    {
        $post = Post::with([
            'author',
            'categories',
            'tags',
            'comments' => fn($q) => $q->where('approved', true)->with('replies')->latest(),
        ])
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

        // Generate meta data for SEO
        $metaData = $this->metaService->forPost($post);

        // Generate JSON-LD structured data
        $jsonLd = $this->schemaService->blogPost($post);

        // Get related posts (same categories or tags)
        $relatedPosts = Post::where('id', '!=', $post->id)
            ->where('status', 'published')
            ->where(function($query) use ($post) {
                $query->whereHas('categories', function($q) use ($post) {
                    $q->whereIn('categories.id', $post->categories->pluck('id'));
                })->orWhereHas('tags', function($q) use ($post) {
                    $q->whereIn('tags.id', $post->tags->pluck('id'));
                });
            })
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'metaData', 'jsonLd', 'relatedPosts'));
    }
}

