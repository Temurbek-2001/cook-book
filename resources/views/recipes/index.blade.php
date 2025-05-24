
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
    @if($recipes->count())
        <!-- Stats Bar -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600">{{ $recipes->total() }}</div>
                    <div class="text-gray-600">Total Recipes</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $recipes->where('difficulty_level', 'easy')->count() }}</div>
                    <div class="text-gray-600">Easy Recipes</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-orange-600">{{ $recipes->unique('category_id')->count() }}</div>
                    <div class="text-gray-600">Categories</div>
                </div>
            </div>
        </div>

        <!-- Recipe Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($recipes as $recipe)
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover">
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
                        <div class="absolute bottom-4 right-4">
                            <button class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all duration-200 group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.364a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </div>
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
@endsection