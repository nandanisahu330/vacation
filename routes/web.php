<?php

use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Web Resource Routes for Admin Dashboard
Route::resource('posts', PostController::class);

// Direct JSON API endpoints for AJAX / headless integrations
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/posts', [PostApiController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostApiController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostApiController::class, 'show'])->name('posts.show');
    Route::post('/posts/{post}', [PostApiController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostApiController::class, 'destroy'])->name('posts.destroy');
});

Route::get('/test', [TestController::class, 'index']);
