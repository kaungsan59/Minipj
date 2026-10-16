<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndexController;

// login,register

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// admin

Route::get('/admin/home', function () {
    return view('admin.home');
})->middleware('auth')->name('adminhome');

Route::get('/admin/home', [AuthController::class, 'index'])->name('adminhome');

Route::middleware('auth')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::post('/categories', [CategoryController::class, 'store'])
        ->name('categories.store');

    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
        ->name('categories.edit');

    Route::put('/categories/{category}', [CategoryController::class, 'update'])
        ->name('categories.update');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])
        ->name('posts.index');

    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('/posts/store', [PostController::class, 'store'])
        ->name('posts.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');

    Route::put('/posts/{post}', [PostController::class, 'update'])
        ->name('posts.update');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');
});

Route::middleware('auth')->group(function () {

    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create');

    Route::post('/users/store', [UserController::class, 'store'])
        ->name('users.store');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('users.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');

});

// user

Route::middleware('auth')->group(function () {

    Route::get('/user/home', [IndexController::class, 'index'])
        ->name('user.index');

    Route::get('/user/posts/{post}', [IndexController::class, 'show'])
        ->name('user.posts.show');

});