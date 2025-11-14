<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\NewsletterController;

Route::prefix('v1')->group(function () {
    // Posts
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{slug}', [PostController::class, 'show']);
    Route::get('posts/category/{categoryId}', [PostController::class, 'byCategory']);
    Route::get('posts/author/{authorId}', [PostController::class, 'byAuthor']);
    Route::get('posts/tag/{tagId}', [PostController::class, 'byTag']);
    Route::get('posts/search', [PostController::class, 'search']);
    
    // Categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{slug}', [CategoryController::class, 'show']);
    
    // Authors
    Route::get('authors', [AuthorController::class, 'index']);
    Route::get('authors/{id}', [AuthorController::class, 'show']);
    
    // Tags
    Route::get('tags', [TagController::class, 'index']);
    Route::get('tags/{slug}', [TagController::class, 'show']);
    
    // Newsletter
    Route::post('newsletter', [NewsletterController::class, 'store']);
});
