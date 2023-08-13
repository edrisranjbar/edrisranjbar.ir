<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TutorialController;

Route::get('/', [HomeController::class, 'index']);
Route::get('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::get('admin/login/resetPassword', [AdminAuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::get('admin/login/resetPasswordLinkSent', [AdminAuthController::class, 'showResetPasswordLinkSent'])->name('password.resetLinkSent');
Route::get('admin/login/forgotPassword', [AdminAuthController::class, 'forgotPassword'])->name('admin.forgotPassword');
Route::patch('admin/resetPassword', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');
Route::post('admin/login/forgotPassword', [AdminAuthController::class, 'processForgotPassword']);
Route::post('admin/login', [AdminAuthController::class, 'processLogin']);
Route::get('tutorials', [TutorialController::class, 'publicPage']);
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('profile', [AdminProfileController::class, 'show'])->name('admin.profile');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/', function () {
        return view('admin.index');
    });
    Route::resource('pages', PageController::class);
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('portfolios', PortfolioController::class);
    Route::resource('tutorials', TutorialController::class);
    Route::patch('settings', [SettingController::class, 'updateAll'])->name('settings.updateAll');
    Route::resource('settings', SettingController::class);
});
