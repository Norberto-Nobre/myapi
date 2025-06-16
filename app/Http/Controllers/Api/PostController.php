<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function __construct(protected PostService $postService) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $filters = $request->only(['category', 'author', 'tag', 'search']);
        
        $posts = $this->postService->getPaginatedPosts($perPage, $filters);
        
        return response()->json([
            'success' => true,
            'data' => $posts->items(),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ]
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $post = $this->postService->getPostBySlug($slug);
        
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post não encontrado'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    public function byCategory(int $categoryId): JsonResponse
    {
        $posts = $this->postService->getPostsByCategory($categoryId);
        
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function byAuthor(int $authorId): JsonResponse
    {
        $posts = $this->postService->getPostsByAuthor($authorId);
        
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function byTag(int $tagId): JsonResponse
    {
        $posts = $this->postService->getPostsByTag($tagId);
        
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');
        
        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Query de busca é obrigatória'
            ], 400);
        }
        
        $posts = $this->postService->searchPosts($query);
        
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }
}