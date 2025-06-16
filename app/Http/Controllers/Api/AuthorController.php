<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    public function __construct(protected AuthorService $authorService) {}

    public function index(): JsonResponse
    {
        $authors = $this->authorService->getAllActiveAuthors();
        
        return response()->json([
            'success' => true,
            'data' => $authors
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $author = $this->authorService->getAuthorById($id);
        
        if (!$author || !$author->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Autor não encontrado'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $author
        ]);
    }
}