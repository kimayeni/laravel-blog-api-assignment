<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    // GET /api/posts
    public function index()
    {
        return response()->json(Post::all());
    }

    // POST /api/posts
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:posts',
            'content' => 'required',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => auth()->id() ?? 1, // temporary fallback if auth not set yet
        ]);

        return response()->json($post, 201);
    }

    // GET /api/posts/{post}
    public function show(Post $post)
    {
        return response()->json($post);
    }

    // PUT /api/posts/{post}
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|unique:posts,title,' . $post->id,
            'content' => 'required',
        ]);

        $post->update($validated);

        return response()->json($post);
    }

    // DELETE /api/posts/{post}
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }
}