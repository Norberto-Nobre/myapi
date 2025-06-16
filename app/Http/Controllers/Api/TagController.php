<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    public function __construct(protected TagService $tagService) {}

    public function index(): JsonResponse
    {
        $tags = $this->tagService->getAllActiveTags();
        
        return response()->json([
            'success' => true,
            'data' => $tags
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $tag = $this->tagService->getTagBySlug($slug);
        
        if (!$tag || !$tag->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Tag não encontrada'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $tag
        ]);
    }
}