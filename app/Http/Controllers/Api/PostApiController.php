<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostApiController extends Controller
{
    /**
     * Get all posts with filtering and pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $perPage = (int) $request->input('per_page', 10);

        if (! in_array($perPage, [10, 25, 50], true)) {
            $perPage = 10;
        }

        $query = Post::query();

        if (! empty($search)) {
            $query->where('title', 'like', '%'.$search.'%');
        }

        if (! empty($status) && in_array($status, ['Active', 'Inactive'], true)) {
            $query->where('status', $status);
        }

        $posts = $query->latest('id')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $posts->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'has_more' => $posts->hasMorePages(),
            ],
            'counts' => [
                'total' => Post::count(),
                'active' => Post::where('status', 'Active')->count(),
                'inactive' => Post::where('status', 'Inactive')->count(),
            ],
        ]);
    }

    /**
     * Store a newly created post.
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post = Post::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully.',
            'data' => $post,
        ], 201);
    }

    /**
     * Display a single post by ID.
     */
    public function show(Post $post): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => array_merge($post->toArray(), [
                'image_url' => $post->image_url,
            ]),
        ]);
    }

    /**
     * Update an existing post.
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        } else {
            unset($validated['image']);
        }

        $post->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully.',
            'data' => $post,
        ]);
    }

    /**
     * Delete a post.
     */
    public function destroy(Post $post): JsonResponse
    {
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully.',
        ]);
    }
}
