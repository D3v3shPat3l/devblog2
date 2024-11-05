<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // User profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post management
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit'); // Route to edit post
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update'); // Route to update post

    // Comment management
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
});

// Registration routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Password reset routes
Route::get('/forgot-password', [PasswordController::class, 'request'])->name('password.request');
Route::post('/forgot-password', [PasswordController::class, 'email'])->name('password.email');

// Logout route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// User route
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Changes route
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Notification route
Route::post('/notifications/mark-as-read', function () {
    Auth::user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('notifications.markAsRead'); 

// Include additional auth routes
require __DIR__.'/auth.php';
