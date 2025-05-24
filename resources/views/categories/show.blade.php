@extends('layouts.recipe')

@section('title', $category->name . ' Recipes')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-6">
            <a href="{{ route('categories.index') }}" class="text-white/80 hover:text-white transition-colors">Categories</a>
            <span class="mx-2 text-white/60">/</span>
            <span class="text-white">{{ $category->name }}</span>
        </nav>
        
        <h1 class="text-5xl font-bold mb-4">{{ $category->name }} Recipes</h1>
        @if($category->description)
            <p class="text-xl text-white/90 mb-4 max-w-2xl mx-auto">{{ $category->description }}</p>
        @endif
        <p class="text-lg text-white/80 mb-8">{{ $recipes->total() }} {{ Str::plural('recipe', $recipes->total()) }} in this category</p>
        
        <a href="{{ route('recipes.create') }}" 
           class="inline-flex items-center px-8 py-4 bg-white text-purple-600 font-semibold rounded-full hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Share Your Recipe
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Filters Section -->
    <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('categories.show', $category) }}" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
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
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date Added</option>
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
                <a href="{{ route('categories.show', $category) }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition-all duration-200">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    @if($recipes->count() > 0)
        <!-- Stats Bar -->
        <div class="bg-white rounded-2xl shadow-md p-4 mb-8">
            <div class="flex flex-row justify-between items-center text-center gap-2 text-xs sm:text-sm md:text-base">
                <div class="flex-1">
                    <div class="text-lg font-bold text-purple-600">{{ $recipes->total() }}</div>
                    <div class="text-gray-500">Total Recipes</div>
                </div>
                <div class="flex-1">
                    <div class="text-lg font-bold text-green-600">
                        {{ $recipes->where('difficulty_level', 'easy')->count() }}
                    </div>
                    <div class="text-gray-500">Easy Recipes</div>
                </div>
                <div class="flex-1">
                    <div class="text-lg font-bold text-orange-500">
                        {{ $recipes->where('difficulty_level', 'medium')->count() }}
                    </div>
                    <div class="text-gray-500">Medium Recipes</div>
                </div>
                <div class="flex-1">
                    <div class="text-lg font-bold text-red-500">
                        {{ $recipes->where('difficulty_level', 'hard')->count() }}
                    </div>
                    <div class="text-gray-500">Hard Recipes</div>
                </div>
            </div>
        </div>

        <!-- Recipe Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($recipes as $recipe)
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
                                $bgColor = $difficultyColors[$recipe->difficulty_level] ?? 'bg-gray-500';
                            @endphp
                            <span class="glass-effect {{ $bgColor }} text-white px-3 py-1 rounded-full text-xs font-semibold">
                                {{ ucfirst($recipe->difficulty_level ?? 'Easy') }}
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
                        @auth
                            <div class="absolute bottom-4 right-4">
                                <button class="favorite-btn w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all duration-200 group {{ $recipe->isFavoritedBy(auth()->user()) ? 'text-red-500' : 'text-gray-400' }}"
                                        title="{{ $recipe->isFavoritedBy(auth()->user()) ? 'Remove from favorites' : 'Add to favorites' }}">
                                    <svg class="w-5 h-5 transition-colors" 
                                        fill="{{ $recipe->isFavoritedBy(auth()->user()) ? 'currentColor' : 'none' }}" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.364a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </div>
                        @else
                            <div class="absolute bottom-4 right-4">
                                <a href="{{ route('login') }}" 
                                class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all duration-200 group text-gray-400"
                                title="Login to add to favorites">
                                    <svg class="w-5 h-5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.364a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Card Content -->
                    <div class="p-6">
                        <!-- Title -->
                        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-1 hover:text-purple-600 transition-colors">
                            {{ $recipe->title }}
                        </h3>
                        
                        <!-- Category -->
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            {{ $recipe->category->name ?? 'Uncategorized' }}
                        </div>
                        
                        <!-- Description -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                            {{ $recipe->description ?? 'No description available for this delicious recipe.' }}
                        </p>
                        
                        <!-- Author -->
                        <div class="flex items-center mb-4 pb-4 border-b border-gray-100">
                            <div class="w-8 h-8 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-white">
                                    {{ strtoupper(substr($recipe->user->name ?? 'U', 0, 1)) }}
                                </span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-800">{{ $recipe->user->name ?? 'Unknown Chef' }}</p>
                                <p class="text-xs text-gray-500">Recipe Creator</p>
                            </div>
                        </div>
                        
                        <!-- Stats Row -->
                        @auth
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.364a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    {{ $recipe->favorites()->count() }} favorites
                                </span>
                                <span>{{ $recipe->created_at->diffForHumans() }}</span>
                            </div>
                        @endif
                        
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
        <div class="mt-12 flex justify-center">
            <div class="bg-white rounded-2xl shadow-lg p-4">
                {{ $recipes->links('custom-pagination') }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="max-w-md mx-auto">
                <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-16 h-16 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-800 mb-4">
                    @if(request()->hasAny(['search', 'difficulty']))
                        No Recipes Found
                    @else
                        No Recipes in {{ $category->name }} Yet
                    @endif
                </h3>
                
                <p class="text-gray-600 mb-8 leading-relaxed">
                    @if(request()->hasAny(['search', 'difficulty']))
                        No recipes match your current filters. Try adjusting your search criteria or clearing the filters.
                    @else
                        This category is waiting for its first delicious recipe. Be the first to share something amazing!
                    @endif
                </p>
                
                <div class="space-y-4">
                    @if(request()->hasAny(['search', 'difficulty']))
                        <a href="{{ route('categories.show', $category) }}" 
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold rounded-full transform hover:scale-105 transition-all duration-300 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Clear Filters
                        </a>
                    @else
                        <a href="{{ route('recipes.create') }}" 
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold rounded-full transform hover:scale-105 transition-all duration-300 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Create First Recipe
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

@auth
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

// Add event listeners for favorite buttons on recipe list pages
document.addEventListener('DOMContentLoaded', function() {
    // Handle favorite buttons in recipe cards (for index pages)
    const favoriteCards = document.querySelectorAll('[data-favorite-recipe]');
    
    favoriteCards.forEach(card => {
        const recipeId = card.dataset.favoriteRecipe;
        const favoriteBtn = card.querySelector('.favorite-btn');
        
        if (favoriteBtn) {
            favoriteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleFavoriteCard(recipeId, card);
            });
        }
    });
});

/**
 * Toggle favorite for recipe cards (used in recipe listings)
 * @param {number} recipeId - The ID of the recipe
 * @param {Element} card - The card element containing the recipe
 */
function toggleFavoriteCard(recipeId, card) {
    const favoriteBtn = card.querySelector('.favorite-btn');
    const heartIcon = favoriteBtn.querySelector('svg');
    
    favoriteBtn.disabled = true;
    favoriteBtn.style.opacity = '0.6';
    
    fetch(`/recipes/${recipeId}/favorite/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.is_favorited) {
                favoriteBtn.classList.add('text-red-500');
                heartIcon.setAttribute('fill', 'currentColor');
            } else {
                favoriteBtn.classList.remove('text-red-500');
                heartIcon.setAttribute('fill', 'none');
            }
            
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message || 'An error occurred', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while updating favorites', 'error');
    })
    .finally(() => {
        favoriteBtn.disabled = false;
        favoriteBtn.style.opacity = '1';
    });
}
</script>
@endauth
@endsection