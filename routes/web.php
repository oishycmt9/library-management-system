<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Admin\PublisherController as AdminPublisherController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('categories', AdminCategoryController::class)
        ->except('show');

    Route::resource('authors', AdminAuthorController::class)
        ->except('show');

    Route::resource('publishers', AdminPublisherController::class)
        ->except('show');

    Route::resource('books', AdminBookController::class)
        ->except('show');

    Route::resource('borrowings', AdminBorrowingController::class)
        ->except('show');

    });
