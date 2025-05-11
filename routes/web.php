<?php

use Spatie\Honeypot\ProtectAgainstSpam;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteMapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\SettingController;

Route::middleware('analytics')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('sitemap', [SiteMapController::class, 'generate']);
    Route::get('blog', [HomeController::class, 'blog']);
    Route::get('blog/{slug}', [HomeController::class, 'blogPost'])->name('blog.show');
    Route::post('contact', [ContactFormController::class, 'store'])->name('contact.store')->middleware(ProtectAgainstSpam::class);
    Route::post('comments', [CommentController::class, 'store']);
    Route::get('donate/verify', [DonationController::class, 'verify']);
    Route::post('donate', [DonationController::class, 'request'])->name('donation.request');
});

Route::get('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::get('admin/login/resetPassword', [AdminAuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::get('admin/login/resetPasswordLinkSent', [AdminAuthController::class, 'showResetPasswordLinkSent'])->name('password.resetLinkSent');
Route::get('admin/login/forgotPassword', [AdminAuthController::class, 'forgotPassword'])->name('admin.forgotPassword');
Route::post('admin/login/forgotPassword', [AdminAuthController::class, 'processForgotPassword']);
Route::post('admin/login', [AdminAuthController::class, 'processLogin']);

Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('profile', [AdminProfileController::class, 'show'])->name('admin.profile');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::patch('settings', [SettingController::class, 'updateAll'])->name('settings.updateAll');
    Route::resource('settings', SettingController::class);
    Route::resource('comments', CommentController::class);
    Route::patch('comments/{commentId}/reply', [CommentController::class, 'reply']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('comments/{commentId}/toggleApprovementStatus', [CommentController::class, 'toggleApprovementStatus']);
});