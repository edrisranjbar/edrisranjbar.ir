<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\TestResendController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Contact Form Endpoint
Route::post('/contact', [ContactController::class, 'store']);
// Alternative endpoint to avoid ad-blockers
Route::post('/send-message', [ContactController::class, 'store']);

// Test Resend Email (only in local/development environment)
if (app()->environment(['local', 'development'])) {
    Route::get('/test-email', [TestResendController::class, 'testEmail']);
}

// Health Check Endpoint
Route::get('/health', function() {
    return response()->json([
        'success' => true,
        'message' => 'سیستم فعال است',
        'status' => 'UP'
    ]);
}); 