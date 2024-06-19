<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\UrlInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('fetchUrl/', [UrlInfoController::class, 'fetch']);
Route::delete('admin/comments/{commentId}/deleteReply', [CommentController::class, 'deleteReplyAjax']);
Route::patch('admin/comments/{commentId}/reply', [CommentController::class, 'replyAjax']);