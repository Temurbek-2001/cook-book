
@extends('layouts.recipe')

@section('title', 'All Recipes')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-4">Discover Amazing Recipes</h1>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Explore our collection of delicious recipes from around the world, shared by passionate home cooks.
        </p>
        <a href="{{ auth()->check() ? route('recipes.create') : route('login') }}"
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
    @if($recipes->count())
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
                        {{ $recipes->unique('category_id')->count() }}
                    </div>
                    <div class="text-gray-500">Categories</div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">No Recipes Yet</h3>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Your recipe collection is empty. Start your culinary journey by sharing your first amazing recipe with the community!
                </p>
                <div class="space-y-4">
                    <a href="{{ route('recipes.create') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold rounded-full transform hover:scale-105 transition-all duration-300 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Your First Recipe
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@auth
<script>
/**
 * Toggle favorite status for a recipe
 * @param {number} recipeId - The ID of the recipe to toggle
 */
function toggleFavorite(recipeId) {
    const favoriteBtn = document.getElementById('favorite-btn');
    const favoriteText = document.getElementById('favorite-text');
    const heartIcon = favoriteBtn.querySelector('svg');
    
    // Disable button during request
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
            // Update button appearance
            if (data.is_favorited) {
                favoriteBtn.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                favoriteBtn.classList.add('bg-red-100', 'text-red-600');
                heartIcon.setAttribute('fill', 'currentColor');
                favoriteText.textContent = 'Favorited';
            } else {
                favoriteBtn.classList.remove('bg-red-100', 'text-red-600');
                favoriteBtn.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                heartIcon.setAttribute('fill', 'none');
                favoriteText.textContent = 'Add to Favorites';
            }
            
            // Show success message (optional)
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
        // Re-enable button
        favoriteBtn.disabled = false;
        favoriteBtn.style.opacity = '1';
    });
}

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
