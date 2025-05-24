<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Constructor removed - middleware will be applied in routes

    /**
     * Display a listing of user's favorite recipes.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->favoriteRecipes()->with(['user', 'category']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('ingredients', 'like', "%{$search}%");
            });
        }
        
        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->get('category'));
        }
        
        // Difficulty filter
        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->get('difficulty'));
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'favorites.created_at');
        $sortOrder = $request->get('order', 'desc');
        
        switch ($sortBy) {
            case 'title':
                $query->orderBy('title', $sortOrder);
                break;
            case 'preparation_time':
                $query->orderBy('preparation_time', $sortOrder);
                break;
            case 'cooking_time':
                $query->orderBy('cooking_time', $sortOrder);
                break;
            case 'difficulty':
                $query->orderBy('difficulty_level', $sortOrder);
                break;
            default:
                $query->orderBy('favorites.created_at', $sortOrder);
        }
        
        $favoriteRecipes = $query->paginate(12)->withQueryString();
        
        // Get categories for filter dropdown
        $categories = \App\Models\Category::all();
        
        return view('favorites.index', compact('favoriteRecipes', 'categories'));
    }

    /**
     * Add a recipe to favorites.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
        ]);

        $recipe = Recipe::findOrFail($request->recipe_id);
        
        // Check if already favorited
        $existingFavorite = Favorite::where('user_id', Auth::id())
                                  ->where('recipe_id', $recipe->id)
                                  ->first();

        if ($existingFavorite) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recipe is already in your favorites.'
                ], 409);
            }
            
            return redirect()->back()
                            ->with('error', 'Recipe is already in your favorites.');
        }

        Favorite::create([
            'user_id' => Auth::id(),
            'recipe_id' => $recipe->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Recipe added to favorites!',
                'is_favorited' => true,
                'favorites_count' => $recipe->favorites()->count()
            ]);
        }

        return redirect()->back()
                        ->with('success', 'Recipe added to favorites!');
    }

    /**
     * Remove a recipe from favorites.
     */
    public function destroy(Request $request, Recipe $recipe)
    {
        $favorite = Favorite::where('user_id', Auth::id())
                           ->where('recipe_id', $recipe->id)
                           ->first();

        if (!$favorite) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recipe is not in your favorites.'
                ], 404);
            }
            
            return redirect()->back()
                            ->with('error', 'Recipe is not in your favorites.');
        }

        $favorite->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Recipe removed from favorites!',
                'is_favorited' => false,
                'favorites_count' => $recipe->favorites()->count()
            ]);
        }

        return redirect()->back()
                        ->with('success', 'Recipe removed from favorites!');
    }

    /**
     * Toggle favorite status (for AJAX requests).
     */
    public function toggle(Recipe $recipe)
    {
        $favorite = Favorite::where('user_id', Auth::id())
                           ->where('recipe_id', $recipe->id)
                           ->first();

        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            $is_favorited = false;
            $message = 'Recipe removed from favorites!';
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => Auth::id(),
                'recipe_id' => $recipe->id,
            ]);
            $is_favorited = true;
            $message = 'Recipe added to favorites!';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'is_favorited' => $is_favorited,
            'favorites_count' => $recipe->favorites()->count()
        ]);
    }
}