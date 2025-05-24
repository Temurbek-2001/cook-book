@extends('layouts.recipe')

@section('title', 'Create New Recipe')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-purple-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Create New Recipe</h1>
                    <p class="text-gray-600 mt-1 text-sm sm:text-base">Share your delicious creation with the community</p>
                </div>
                <a href="{{ route('recipes.index') }}" 
                   class="flex items-center text-gray-600 hover:text-purple-600 transition-colors text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Recipes
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
            @csrf
            
            <!-- Basic Info -->
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Basic Information</h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Title -->
                    <div class="lg:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Recipe Title *</label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title') }}"
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm sm:text-base"
                               placeholder="e.g. Grandma's Chocolate Chip Cookies"
                               required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select name="category_id" 
                                id="category_id" 
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm sm:text-base"
                                required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Difficulty -->
                    <div>
                        <label for="difficulty_level" class="block text-sm font-medium text-gray-700 mb-2">Difficulty Level *</label>
                        <select name="difficulty_level" 
                                id="difficulty_level" 
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm sm:text-base"
                                required>
                            <option value="">Select difficulty</option>
                            <option value="easy" {{ old('difficulty_level') == 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty_level') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty_level') == 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                        @error('difficulty_level')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prep Time -->
                    <div>
                        <label for="preparation_time" class="block text-sm font-medium text-gray-700 mb-2">Prep Time (minutes) *</label>
                        <input type="number" 
                               name="preparation_time" 
                               id="preparation_time" 
                               value="{{ old('preparation_time') }}"
                               min="1"
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm sm:text-base"
                               placeholder="e.g. 15"
                               required>
                        @error('preparation_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cook Time -->
                    <div>
                        <label for="cooking_time" class="block text-sm font-medium text-gray-700 mb-2">Cook Time (minutes) *</label>
                        <input type="number" 
                               name="cooking_time" 
                               id="cooking_time" 
                               value="{{ old('cooking_time') }}"
                               min="1"
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm sm:text-base"
                               placeholder="e.g. 12"
                               required>
                        @error('cooking_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="lg:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="3"
                                  class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all resize-none text-sm sm:text-base"
                                  placeholder="Tell us about your recipe...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Recipe Image</h2>
                
                <div class="border-2 border-dashed border-gray-300 rounded-lg sm:rounded-xl p-4 sm:p-6 text-center hover:border-purple-400 transition-colors">
                    <input type="file" 
                           name="image_path" 
                           id="image_path" 
                           accept="image/*"
                           class="hidden"
                           onchange="previewImage(this)">
                    
                    <div id="image-preview" class="hidden">
                        <img id="preview-img" src="#" alt="Preview" class="mx-auto max-h-32 sm:max-h-48 rounded-lg mb-4 w-auto">
                        <button type="button" 
                                onclick="removeImage()"
                                class="text-red-600 hover:text-red-800 text-sm">
                            Remove Image
                        </button>
                    </div>
                    
                    <div id="upload-placeholder">
                        <svg class="w-8 h-8 sm:w-12 sm:h-12 text-gray-400 mx-auto mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-gray-600 mb-2 text-sm sm:text-base">Click to upload recipe image</p>
                        <p class="text-xs sm:text-sm text-gray-500">PNG, JPG up to 2MB</p>
                        <button type="button" 
                                onclick="document.getElementById('image_path').click()"
                                class="mt-3 sm:mt-4 px-4 sm:px-6 py-2 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-colors text-sm sm:text-base">
                            Choose File
                        </button>
                    </div>
                </div>
                @error('image_path')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ingredients -->
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Ingredients *</h2>
                
                <div id="ingredients-container" class="space-y-3">
                    @if(old('ingredients'))
                        @foreach(old('ingredients') as $index => $ingredient)
                            <div class="ingredient-item flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                                <input type="text" 
                                       name="ingredients[]" 
                                       value="{{ $ingredient }}"
                                       class="flex-1 px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm sm:text-base"
                                       placeholder="e.g. 2 cups all-purpose flour"
                                       required>
                                <button type="button" 
                                        onclick="removeIngredient(this)"
                                        class="w-full sm:w-10 h-10 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors flex items-center justify-center text-sm sm:text-base">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <svg class="w-5 h-5 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span class="sm:hidden ml-2">Remove</span>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="ingredient-item flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                            <input type="text" 
                                   name="ingredients[]" 
                                   class="flex-1 px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm sm:text-base"
                                   placeholder="e.g. 2 cups all-purpose flour"
                                   required>
                            <button type="button" 
                                    onclick="removeIngredient(this)"
                                    class="w-full sm:w-10 h-10 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors flex items-center justify-center text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <svg class="w-5 h-5 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span class="sm:hidden ml-2">Remove</span>
                            </button>
                        </div>
                    @endif
                </div>
                
                <button type="button" 
                        onclick="addIngredient()"
                        class="flex items-center justify-center w-full sm:w-auto px-4 py-2 mt-4 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-colors text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Ingredient
                </button>
                
                @error('ingredients')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
                @error('ingredients.*')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Instructions -->
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Instructions *</h2>
                <textarea name="instructions" 
                          id="instructions" 
                          rows="6"
                          class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all resize-none text-sm sm:text-base"
                          placeholder="Step-by-step instructions for your recipe..."
                          required>{{ old('instructions') }}</textarea>
                @error('instructions')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end space-y-reverse space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('recipes.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors text-center text-sm sm:text-base">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 sm:px-8 py-3 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-200 shadow-lg text-sm sm:text-base">
                    Create Recipe
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function addIngredient() {
    const container = document.getElementById('ingredients-container');
    const newIngredient = document.createElement('div');
    newIngredient.className = 'ingredient-item flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3';
    newIngredient.innerHTML = `
        <input type="text" 
               name="ingredients[]" 
               class="flex-1 px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm sm:text-base"
               placeholder="e.g. 1 tsp vanilla extract"
               required>
        <button type="button" 
                onclick="removeIngredient(this)"
                class="w-full sm:w-10 h-10 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors flex items-center justify-center text-sm sm:text-base">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <svg class="w-5 h-5 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <span class="sm:hidden ml-2">Remove</span>
        </button>
    `;
    container.appendChild(newIngredient);
}

function removeIngredient(button) {
    const container = document.getElementById('ingredients-container');
    if (container.children.length > 1) {
        button.parentElement.remove();
    }
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    document.getElementById('image_path').value = '';
    document.getElementById('image-preview').classList.add('hidden');
    document.getElementById('upload-placeholder').classList.remove('hidden');
}
</script>
@endsection