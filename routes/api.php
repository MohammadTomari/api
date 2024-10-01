<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\UserController;

Route::prefix('v1')
->group(function () {
    // Authentication
    Route::post('register', [AuthenticationController::class, 'register']);
    Route::post('login', [AuthenticationController::class, 'login']);

    // Users
    Route::prefix('user')
    ->middleware('auth:api')
    ->group(function() {
        Route::get('profile', [UserController::class, 'profile']);
        Route::put('profile/update', [UserController::class, 'update']);
    });

    // Posts
    Route::prefix('post')
    ->group(function() {
        Route::get('index', [PostController::class, 'index']);
        Route::post('store', [PostController::class, 'store'])
        ->middleware('auth:api');
        Route::post('update', [PostController::class, 'update'])
        ->middleware('auth:api');
        Route::post('delete', [PostController::class, 'delete'])
        ->middleware('auth:api');
        Route::post('comments', [CommentController::class, 'getCommentsByPostId'])
        ->middleware('auth:api');
        Route::get('userPosts', [PostController::class, 'userPosts'])
        ->middleware('auth:api');
    });

    // Comment
    Route::prefix('comment')
    ->group(function() {
        Route::get('index', [CommentController::class, 'index']);
        Route::post('store', [CommentController::class, 'store'])
        ->middleware('auth:api');
    });
});
