@extends('layouts.recipe')

@section('title', 'My Favorite Recipes')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-6">
            <a href="{{ route('recipes.index') }}" class="text-white/80 hover:text-white transition-colors">Recipes</a>
            <span class="mx-2 text-white/60">/</span>
            <span class="text-white">My Favorites</span>
        </nav>
        
        <h1 class="text-5xl font-bold mb-4">My Favorite Recipes</h1>
        <p class="text-xl text-white/90 mb-4 max-w-2xl mx-auto">Your collection of saved recipes</p>
        @if($favoriteRecipes->total() > 0)
            <p class="text-lg text-white/80 mb-8">{{ $favoriteRecipes->total() }} {{ Str::plural('recipe', $favoriteRecipes->total()) }} in your collection</p>
        @endif
        
        <a href="{{ route('recipes.index') }}" 
           class="inline-flex items-center px-8 py-4 bg-white text-purple-600 font-semibold rounded-full hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Browse More Recipes
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($favoriteRecipes->total() > 0)
        <!-- Filters Section -->
        <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
            <form method="GET" action="{{ route('favorites.index') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Recipes</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   placeholder="Search by title, description..."
                                   class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <select id="category" name="category" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none bg-white transition-all duration-200">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Difficulty Filter -->
                    <div>
                        <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <select id="difficulty" name="difficulty" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none bg-white transition-all duration-200">
                                <option value="">All Difficulties</option>
                                <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                        </div>
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                            </svg>
                            <select id="sort" name="sort" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none bg-white transition-all duration-200">
                                <option value="favorites.created_at" {{ request('sort') == 'favorites.created_at' ? 'selected' : '' }}>Date Favorited</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
                                <option value="preparation_time" {{ request('sort') == 'preparation_time' ? 'selected' : '' }}>Prep Time</option>
                                <option value="cooking_time" {{ request('sort') == 'cooking_time' ? 'selected' : '' }}>Cook Time</option>
                                <option value="difficulty" {{ request('sort') == 'difficulty' ? 'selected' : '' }}>Difficulty</option>
                            </select>
                        </div>
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                            <select id="order" name="order" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none bg-white transition-all duration-200">
                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('favorites.index') }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition-all duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Stats Bar -->
        <div class="bg-white rounded-2xl shadow-md p-4 mb-8">
            <div class="flex flex-row justify-between items-center text-center gap-2 text-xs sm:text-sm md:text-base">
                <div class="flex-1">
                    <div class="text-lg font-bold text-purple-600">{{ $favoriteRecipes->total() }}</div>
                    <div class="text-gray-500">Total Favorites</div>
                </div>
                <div class="flex-1">
                    <div class="text-lg font-bold text-green-600">
                        {{ $favoriteRecipes->where('difficulty_level', 'easy')->count() }}
                    </div>
                    <div class="text-gray-500">Easy Recipes</div>
                </div>
                <div class="flex-1">
                    <div class="text-lg font-bold text-orange-500">
                        {{ $favoriteRecipes->where('difficulty_level', 'medium')->count() }}
                    </div>
                    <div class="text-gray-500">Medium Recipes</div>
                </div>
                <div class="flex-1">
                    <div class="text-lg font-bold text-red-500">
                        {{ $favoriteRecipes->where('difficulty_level', 'hard')->count() }}
                    </div>
                    <div class="text-gray-500">Hard Recipes</div>
                </div>
            </div>
        </div>

        <!-- Recipe Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($favoriteRecipes as $recipe)
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover" data-favorite-recipe="{{ $recipe->id }}">
                    <!-- Image Container -->
                    <div class="relative h-48 overflow-hidden">
                        <img
                            src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : asset('images/default-recipe.jpg') }}" 
                            alt="{{ $recipe->title }}"
                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-110"
                            onerror="this.src='https://via.placeholder.com/400x300/f1f5f9/64748b?text=Recipe'"
                        >
                        
                        <!-- Overlay Badges -->
                        <div class="absolute top-4 left-4">
                            @php
                                $difficultyColors = [
                                    'easy' => 'bg-green-500',
                                    'medium' => 'bg-yellow-500', 
                                    'hard' => 'bg-red-500'
                                ];
                                $bgColor = $difficultyColors[$recipe->difficulty] ?? 'bg-gray-500';
                            @endphp
                            <span class="glass-effect {{ $bgColor }} text-white px-3 py-1 rounded-full text-xs font-semibold">
                                {{ ucfirst($recipe->difficulty ?? 'Easy') }}
                            </span>
                        </div>
                        
                        <div class="absolute top-4 right-4">
                            <span class="glass-effect bg-black/50 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ ($recipe->preparation_time ?? 0) + ($recipe->cooking_time ?? 0) }}min
                            </span>
                        </div>

                        <!-- Favorite Button -->
                        <div class="absolute bottom-4 right-4">
                            <button onclick="removeFavorite({{ $recipe->id }})" 
                                    id="favorite-btn-{{ $recipe->id }}"
                                    class="favorite-btn w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all duration-200 group text-red-500"
                                    title="Remove from favorites">
                                <svg class="w-5 h-5 transition-colors" 
                                    fill="currentColor" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.364a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6">
                        <!-- Title -->
                        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-1 hover:text-purple-600 transition-colors">
                            <a href="{{ route('recipes.show', $recipe) }}">{{ $recipe->title }}</a>
                        </h3>
                        
                        <!-- Category -->
                        @if($recipe->category)
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                {{ $recipe->category->name }}
                            </div>
                        @endif
                        
                        <!-- Description -->
                        @if($recipe->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                                {{ $recipe->description }}
                            </p>
                        @endif
                        
                        <!-- Author -->
                        @if($recipe->user)
                            <div class="flex items-center mb-4 pb-4 border-b border-gray-100">
                                <div class="w-8 h-8 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-white">
                                        {{ strtoupper(substr($recipe->user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-800">{{ $recipe->user->name }}</p>
                                    <p class="text-xs text-gray-500">Recipe Creator</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Stats Row -->
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.364a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Added {{ $recipe->pivot->created_at->diffForHumans() }}
                            </span>
                            @if($recipe->servings)
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    {{ $recipe->servings }} servings
                                </span>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('recipes.show', $recipe) }}"
                            class="flex-1 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white text-center py-2.5 px-4 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 mr-2">
                                View Recipe
                            </a>
                            
                            <div class="flex space-x-2">
                                @can('update', $recipe)
                                    <a href="{{ route('recipes.edit', $recipe) }}"
                                    class="w-10 h-10 bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-xl flex items-center justify-center transition-colors duration-200"
                                    title="Edit Recipe">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                @endcan
                                
                                @can('delete', $recipe)
                                    <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="inline"
                                        onsubmit="return confirm('🗑️ Delete this delicious recipe?\n\nThis action cannot be undone!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-10 h-10 bg-red-100 hover:bg-red-200 text-red-600 rounded-xl flex items-center justify-center transition-colors duration-200"
                                                title="Delete Recipe">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($favoriteRecipes->hasPages())
            <div class="mt-12 flex justify-center">
                <div class="bg-white rounded-2xl shadow-lg p-4">
                    {{ $favoriteRecipes->appends(request()->query())->links() }}
                </div>
            </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="max-w-md mx-auto">
                <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-16 h-16 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.364a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-800 mb-4">No Favorite Recipes Yet</h3>
                
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Start building your collection by adding recipes to your favorites. 
                    Look for the heart icon on any recipe to save it here.
                </p>
                
                <div class="space-y-4">
                    <a href="{{ route('recipes.index') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold rounded-full transform hover:scale-105 transition-all duration-300 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Browse Recipes
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="success-toast">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="error-toast">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
@endif

<script>
/**
 * Show notification message
 * @param {string} message - The message to display
 * @param {string} type - The type of notification ('success' or 'error')
 */
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
        type === 'success' 
            ? 'bg-green-500 text-white' 
            : 'bg-red-500 text-white'
    }`;
    notification.textContent = message;
    
    // Add to DOM
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

async function removeFavorite(recipeId) {
    const btn = document.getElementById(`favorite-btn-${recipeId}`);
    const recipeCard = btn.closest('.bg-white');
    
    if (!confirm('Remove this recipe from your favorites?')) {
        return;
    }
    
    try {
        const response = await fetch(`/recipes/${recipeId}/favorite`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Animate card removal
            recipeCard.style.transform = 'scale(0.95)';
            recipeCard.style.opacity = '0.5';
            
            setTimeout(() => {
                recipeCard.remove();
                
                // Check if page is now empty
                const remainingCards = document.querySelectorAll('.grid .bg-white').length;
                if (remainingCards === 0) {
                    location.reload();
                }
            }, 300);
            
            // Show success message
            showNotification('Recipe removed from favorites!', 'success');
        } else {
            showNotification(data.message || 'Failed to remove recipe from favorites', 'error');
        }
    
      } catch (error) {
            console.error('Error removing favorite:', error);
            showToast('Failed to remove recipe from favorites', 'error');
      }
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
            ${message}
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Auto-hide session toasts
setTimeout(() => {
    const toasts = document.querySelectorAll('#success-toast, #error-toast');
    toasts.forEach(toast => {
        if (toast) {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }
    });
}, 3000);
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection