<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService) {}

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllActiveCategories();
        
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $category = $this->categoryService->getCategoryBySlug($slug);
        
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Categoria não encontrada'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }
}