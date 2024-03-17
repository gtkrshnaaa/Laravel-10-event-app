<?php

// app/Http/Controllers/BlogController.php


namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter kategori dari request
        $category = $request->input('category');

        // Daftar kategori termasuk 'All' (ini harus sama dengan data kategori di file migrasi kategori)
        $categories = ['All', 'music events', 'sports events', 'cultural events', 'business events', 'social events', 'educational events'];

        // Bangun query berdasarkan kategori jika ada
        $query = Post::where('status', 'public');
        if ($category && $category !== 'All' && in_array($category, $categories)) {
            $query->where('category', $category);
        }

        // Ambil post dengan atau tanpa filter kategori
        $posts = $query->orderBy('id', 'desc')->simplePaginate(12);

        return view('posts.index', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        if (auth()->id() != $post->user_id and $post->status === 'private') {
            abort(404);
        }

        $comments = Comment::orderBy('id', 'desc')->get();

        return view('posts.show', compact('post', 'comments'));
    }
}
