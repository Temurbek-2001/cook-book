<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::withCount('recipes')->get();
        
        return view('categories.index', compact('categories'));
    }

    /**
     * Display the specified category with its recipes.
     */
    public function show(Category $category, Request $request)
    {
        $query = $category->recipes()->with(['user', 'category']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('ingredients', 'like', "%{$search}%");
            });
        }
        
        // Difficulty filter
        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->get('difficulty'));
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'created_at');
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
                $query->orderBy('created_at', $sortOrder);
        }
        
        $recipes = $query->paginate(12)->withQueryString();
        
        return view('categories.show', compact('category', 'recipes'));
    }

    /**
     * Store a newly created category in storage.
     * (Admin only functionality)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:500',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')
                        ->with('success', 'Category created successfully.');
    }

    /**
     * Update the specified category in storage.
     * (Admin only functionality)
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')
                        ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     * (Admin only functionality)
     */
    public function destroy(Category $category)
    {
        // Check if category has recipes
        if ($category->recipes()->count() > 0) {
            return redirect()->route('categories.index')
                            ->with('error', 'Cannot delete category that contains recipes.');
        }

        $category->delete();

        return redirect()->route('categories.index')
                        ->with('success', 'Category deleted successfully.');
    }
}