<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::middleware('throttle:auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'getUser']);
    });
});

Route::middleware('auth:sanctum')->prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show'])->whereNumber('id');
    Route::get('/category/{category}', [ProductController::class, 'getByCategory'])->whereNumber('category');
    Route::get('/search/{search}', [ProductController::class, 'search']);

    Route::middleware('throttle:product-writes')->group(function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update'])->whereNumber('id');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->whereNumber('id');
    });
});
