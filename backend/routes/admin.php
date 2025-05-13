<?php

use App\Http\Controllers\Api\AdminAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for the admin area.
|
*/

// Admin Authentication Routes (Public)
Route::post('/login', [AdminAuthController::class, 'login']);

// Protected Admin Routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Authentication
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::get('/profile', [AdminAuthController::class, 'profile']);
    Route::post('/change-password', [AdminAuthController::class, 'changePassword']);
    
    // Blog Management Routes
    Route::apiResource('categories', \App\Http\Controllers\Api\CategoryController::class);
    Route::apiResource('posts', \App\Http\Controllers\Api\PostController::class);
    
    // Comment Management Routes
    Route::get('/comments', [\App\Http\Controllers\Api\CommentController::class, 'index']);
    Route::get('/comments/{comment}', [\App\Http\Controllers\Api\CommentController::class, 'show']);
    Route::put('/comments/{comment}', [\App\Http\Controllers\Api\CommentController::class, 'update']);
    Route::patch('/comments/{comment}/status', [\App\Http\Controllers\Api\CommentController::class, 'updateStatus']);
    Route::post('/comments/{comment}/reply', [\App\Http\Controllers\Api\CommentController::class, 'adminReply']);
    Route::delete('/comments/{comment}', [\App\Http\Controllers\Api\CommentController::class, 'destroy']);
}); 