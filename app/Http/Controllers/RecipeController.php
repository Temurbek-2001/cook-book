<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{

    public function index()
    {
        $recipes = Recipe::with(['category', 'user'])->latest()->paginate(10);
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('recipes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array',
            'ingredients.*' => 'string',
            'instructions' => 'required|string',
            'preparation_time' => 'required|integer|min:1',
            'cooking_time' => 'required|integer|min:1',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'image_path' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $path = $request->file('image_path')?->store('recipes', 'public');

        Recipe::create([
            ...$validated,
            'ingredients' => json_encode($validated['ingredients']),
            'image_path' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully.');
    }

    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $categories = Category::all();
        return view('recipes.edit', compact('recipe', 'categories'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array',
            'ingredients.*' => 'string',
            'instructions' => 'required|string',
            'preparation_time' => 'required|integer|min:1',
            'cooking_time' => 'required|integer|min:1',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'image_path' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('recipes', 'public');
            $recipe->image_path = $path;
        }

        $recipe->update([
            ...$validated,
            'ingredients' => json_encode($validated['ingredients']),
        ]);

        return redirect()->route('recipes.index')->with('success', 'Recipe updated successfully.');
    }

    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Recipe deleted successfully.');
    }
}

