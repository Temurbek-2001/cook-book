@extends('layouts.recipe')

@section('title', $recipe->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-purple-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('recipes.index') }}" 
                   class="flex items-center text-gray-600 hover:text-purple-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Recipes
                </a>
                
                <div class="flex items-center space-x-3">
                    @auth
                        <button onclick="toggleFavorite({{ $recipe->id }})" 
                                id="favorite-btn"
                                class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all duration-200 {{ $recipe->isFavoritedBy(auth()->user()) ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            <svg class="w-5 h-5" fill="{{ $recipe->isFavoritedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.364a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span id="favorite-text">{{ $recipe->isFavoritedBy(auth()->user()) ? 'Favorited' : 'Add to Favorites' }}</span>
                        </button>
                    @endauth
                    
                    @can('update', $recipe)
                        <a href="{{ route('recipes.edit', $recipe) }}" 
                           class="flex items-center space-x-2 px-4 py-2 bg-yellow-100 text-yellow-600 rounded-xl hover:bg-yellow-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span>Edit</span>
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image Section -->
            <div class="space-y-6">
                <div class="relative overflow-hidden rounded-2xl shadow-2xl">
                    <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : asset('images/default-recipe.jpg') }}" 
                         alt="{{ $recipe->title }}"
                         class="w-full h-96 object-cover"
                         onerror="this.src='https://via.placeholder.com/600x400/f1f5f9/64748b?text=Recipe+Image'">
                    
                    <!-- Floating Info Cards -->
                    <div class="absolute top-4 left-4 flex flex-col space-y-2">
                        @php
                            $difficultyColors = [
                                'easy' => 'bg-green-500',
                                'medium' => 'bg-yellow-500', 
                                'hard' => 'bg-red-500'
                            ];
                            $bgColor = $difficultyColors[$recipe->difficulty_level] ?? 'bg-gray-500';
                        @endphp
                        <span class="glass-effect {{ $bgColor }} text-white px-4 py-2 rounded-full text-sm font-semibold">
                            {{ ucfirst($recipe->difficulty_level) }}
                        </span>
                        <span class="glass-effect bg-black/50 text-white px-4 py-2 rounded-full text-sm font-semibold">
                            {{ $recipe->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                </div>

                <!-- Recipe Stats -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-xl p-4 text-center shadow-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $recipe->preparation_time }}</div>
                        <div class="text-sm text-gray-600">Prep Time (min)</div>
                    </div>
                    <div class="bg-white rounded-xl p-4 text-center shadow-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $recipe->cooking_time }}</div>
                        <div class="text-sm text-gray-600">Cook Time (min)</div>
                    </div>
                </div>
            </div>

            <!-- Recipe Details -->
            <div class="space-y-6">
                <!-- Title & Author -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $recipe->title }}</h1>
                    
                    <!-- Author Info -->
                    <div class="flex items-center mb-4 pb-4 border-b border-gray-100">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center">
                            <span class="text-sm font-bold text-white">
                                {{ strtoupper(substr($recipe->user->name ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-800">{{ $recipe->user->name ?? 'Unknown Chef' }}</p>
                            <p class="text-sm text-gray-500">Recipe Creator</p>
                        </div>
                    </div>
                    
                    @if($recipe->description)
                        <p class="text-gray-700 leading-relaxed">{{ $recipe->description }}</p>
                    @endif
                </div>

                <!-- Ingredients -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Ingredients
                    </h2>
                    <ul class="space-y-2">
                        @foreach($recipe->ingredients as $ingredient)
                            <li class="flex items-center text-gray-700">
                                <div class="w-2 h-2 bg-purple-400 rounded-full mr-3"></div>
                                {{ $ingredient }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="mt-8">
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Instructions
                </h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($recipe->instructions)) !!}
                </div>
            </div>
        </div>
    </div>
</div>

@auth
<script>
async function toggleFavorite(recipeId) {
    try {
        const response = await fetch(`/recipes/${recipeId}/favorite`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        const btn = document.getElementById('favorite-btn');
        const text = document.getElementById('favorite-text');
        const icon = btn.querySelector('svg');
        
        if (data.favorited) {
            btn.className = 'flex items-center space-x-2 px-4 py-2 rounded-xl transition-all duration-200 bg-red-100 text-red-600';
            text.textContent = 'Favorited';
            icon.setAttribute('fill', 'currentColor');
        } else {
            btn.className = 'flex items-center space-x-2 px-4 py-2 rounded-xl transition-all duration-200 bg-gray-100 text-gray-600 hover:bg-gray-200';
            text.textContent = 'Add to Favorites';
            icon.setAttribute('fill', 'none');
        }
        
        // Show a brief success message
        const message = document.createElement('div');
        message.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        message.textContent = data.message;
        document.body.appendChild(message);
        
        setTimeout(() => {
            message.remove();
        }, 3000);
        
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>
@endauth
@endsection