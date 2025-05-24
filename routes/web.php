<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('recipes', RecipeController::class);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('recipes', RecipeController::class);


// Category routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Admin-only category management (uncomment and add middleware as needed)
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
//     Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
//     Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
// });

// Favorite routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/recipes/{recipe}/favorite', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/recipes/{recipe}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/recipes/{recipe}/favorite/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

require __DIR__.'/auth.php';
