<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;

// Homepage: show recipe index
Route::get('/', [RecipeController::class, 'index'])->name('home');

// Public Recipe Routes - LIST FIRST
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');

// Authenticated Recipe Management Routes - SPECIFIC ROUTES BEFORE WILDCARD
Route::middleware('auth')->group(function () {
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
});

// WILDCARD ROUTE MUST BE LAST - after all specific routes
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

// Public Category Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Admin-only category management
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
//     Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
//     Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
// });

// Authenticated Favorite Routes
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/recipes/{recipe}/favorite', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/recipes/{recipe}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/recipes/{recipe}/favorite/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// Profile Routes (Authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth scaffolding (login, register, etc.)
require __DIR__.'/auth.php';