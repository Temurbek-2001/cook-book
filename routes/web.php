<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

// Homepage now shows recipe index
Route::get('/', [RecipeController::class, 'index'])->name('home');

// Publicly accessible recipe routes: list and view recipes
Route::resource('recipes', RecipeController::class)->only(['index', 'show']);

// Authenticated users: create, edit, delete recipes
Route::middleware('auth')->group(function () {
    Route::resource('recipes', RecipeController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
});

// Authenticated profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public category browsing
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Authenticated favorite routes
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/recipes/{recipe}/favorite', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/recipes/{recipe}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/recipes/{recipe}/favorite/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// Auth scaffolding (login, register, etc.)
require __DIR__.'/auth.php';
