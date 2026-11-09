<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\PublisherController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BorrowingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

/*Category*/
Route::apiResource('categories', CategoryController::class);
/*Author*/
Route::apiResource('authors', AuthorController::class);
/*Publisher*/
Route::apiResource('publishers', PublisherController::class);
/*Books*/
Route::apiResource('books', BookController::class);
/*Borrowing*/
Route::apiResource('borrowings', BorrowingController::class);
/*Order*/
Route::apiResource('orders', OrderController::class);
/*Users*/
Route::apiResource('users', UserController::class);
// Order Return API
Route::get('/orders/{order}/returns', [OrderController::class, 'returns']);
Route::post('/orders/{order}/returns', [OrderController::class, 'processReturn']);

/*Login & Logout*/
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

/*User*/
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Test API
Route::get('/test', function () {
    return response()->json([
        'message' => 'Library Management API is working!'
    ]);
});

