<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseSectionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\LessonController;

Route::get('/', [HomeController::class, 'index']);
Route::get('podcasts', [HomeController::class, 'podcasts']);
Route::get('tutorials', [HomeController::class, 'tutorials'])->name('tutorials');
Route::get('tutorials/{slug}', [HomeController::class, 'tutorial'])->name('tutorials.show');
Route::get('podcasts', [HomeController::class, 'podcasts']);
Route::get('blog', [HomeController::class, 'blog']);
Route::get('blog/{slug}', [HomeController::class, 'blogPost'])->name('blog.show');


Route::get('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::get('admin/login/resetPassword', [AdminAuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::get('admin/login/resetPasswordLinkSent', [AdminAuthController::class, 'showResetPasswordLinkSent'])->name('password.resetLinkSent');
Route::get('admin/login/forgotPassword', [AdminAuthController::class, 'forgotPassword'])->name('admin.forgotPassword');
// Route::patch('admin/resetPassword', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');
Route::post('admin/login/forgotPassword', [AdminAuthController::class, 'processForgotPassword']);
Route::post('admin/login', [AdminAuthController::class, 'processLogin']);

Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('profile', [AdminProfileController::class, 'show'])->name('admin.profile');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/', function () {
        return view('admin.index');
    });
    Route::resource('pages', PageController::class);
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tutorials', TutorialController::class);
    Route::resource('courseSections', CourseSectionController::class);
    Route::resource('lessons', LessonController::class);
    Route::patch('settings', [SettingController::class, 'updateAll'])->name('settings.updateAll');
    Route::resource('settings', SettingController::class);
});
