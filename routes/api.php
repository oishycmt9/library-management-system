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


Route::apiResource('categories', CategoryController::class);
Route::apiResource('authors', AuthorController::class);
Route::apiResource('publishers', PublisherController::class);
Route::apiResource('books', BookController::class);
Route::apiResource('borrowings', BorrowingController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('users', UserController::class);
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

