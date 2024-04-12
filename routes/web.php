<?php

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
use App\Http\Controllers\CourseSectionController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\WishlistController;

Route::middleware('analytics')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('sitemap', [SiteMapController::class, 'generate']);
    Route::get('podcasts', [HomeController::class, 'podcasts']);
    Route::get('tutorials', [HomeController::class, 'tutorials'])->name('tutorials');
    Route::get('tutorials/{slug}', [HomeController::class, 'tutorial'])->name('tutorials.show');
    Route::get('tutorials/{slug}/lessons/{id}', [HomeController::class, 'lesson'])->name('lessons.show');
    Route::post('tutorials/{slug}/enroll', [TutorialController::class, 'enroll'])->name('tutorials.enroll');
    Route::post('wishlist/{id}', [WishlistController::class, 'addOrRemove'])->name('wishlist.addOrRemove');
    Route::get('podcasts', [HomeController::class, 'podcasts']);
    Route::get('blog', [HomeController::class, 'blog']);
    Route::get('blog/{slug}', [HomeController::class, 'blogPost'])->name('blog.show');
    Route::post('contact', [ContactFormController::class, 'store'])->name('contact.store');
    Route::post('comments', [CommentController::class, 'store']);
    Route::get('donate', [HomeController::class, 'donate']);
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
    Route::get('contactForms', [ContactFormController::class, 'index'])->name('admin.contactForm');
    Route::delete('contactForms/{id}', [ContactFormController::class, 'destroy'])->name('contactForms.destroy');
    Route::delete('destroyAll', [ContactFormController::class, 'destroyAll'])->name('contactForms.destroyAll');
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tutorials', TutorialController::class);
    Route::resource('courseSections', CourseSectionController::class);
    Route::resource('lessons', LessonController::class);
    Route::patch('settings', [SettingController::class, 'updateAll'])->name('settings.updateAll');
    Route::resource('settings', SettingController::class);
    Route::resource('comments', CommentController::class);
    Route::patch('comments/{commentId}/reply', [CommentController::class, 'reply']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('comments/{commentId}/toggleApprovementStatus', [CommentController::class, 'toggleApprovementStatus']);
});

Route::get('user/login', [UserAuthController::class, 'login'])->name('user.login');
Route::get('user/register', [UserAuthController::class, 'register'])->name('user.register');
Route::post('user/login', [UserAuthController::class, 'processLogin']);
Route::post('user/register', [UserAuthController::class, 'processRegister']);
Route::get('user/login/resetPassword', [UserAuthController::class, 'showResetPasswordForm'])->name('user.password.reset');
Route::middleware(['user'])->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'dashboard']);
    Route::get('wishlist', [WishlistController::class, 'index'])->name('user.wishlist');
    Route::get('tutorials', [UserController::class, 'courses'])->name('user.tutorials');
    Route::get('profile', [UserController::class, 'show'])->name('user.profile');
    Route::patch('profile', [UserController::class, 'update'])->name('user.update');
    Route::get('logout', [UserAuthController::class, 'logout'])->name('user.logout');
});