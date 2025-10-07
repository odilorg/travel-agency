<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\MetaService;
use App\Services\SchemaService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
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

