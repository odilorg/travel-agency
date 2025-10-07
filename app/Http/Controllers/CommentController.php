<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Post $post, Request $request)
    {
        $data = $request->validate([
            'author_name' => 'required|max:100',
            'author_email' => 'required|email|max:150',
            'body' => 'required|max:3000',
            'honeypot' => 'nullable',
        ]);

        // Simple honeypot
        if (!empty($data['honeypot'])) {
            return back()->with('error', 'Spam detected.');
        }

        $post->comments()->create([
            'author_name' => $data['author_name'],
            'author_email' => $data['author_email'],
            'body' => $data['body'],
            'approved' => false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Thanks! Your comment is awaiting approval.');
    }
}


