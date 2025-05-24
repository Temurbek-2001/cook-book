@extends('layouts.recipe')

@section('title', 'Recipe Categories')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-4">Recipe Categories</h1>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Explore our diverse collection of recipe categories, from appetizers to desserts, and discover your next culinary adventure.
        </p>
        @auth
            @if(auth()->user()->is_admin)
                <button onclick="openCreateModal()" 
                       class="inline-flex items-center px-8 py-4 bg-white text-purple-600 font-semibold rounded-full hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add New Category
                </button>
            @endif
        @endauth
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl mb-8 shadow-md">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl mb-8 shadow-md">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if($categories->count())
        <!-- Stats Bar -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg p-6 mb-12 border border-white/20">
            <div class="flex flex-row justify-between items-center text-center gap-8">
                <div class="flex-1">
                    <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">{{ $categories->count() }}</div>
                    <div class="text-gray-600 font-medium">Total Categories</div>
                </div>
                <div class="flex-1">
                    <div class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                        {{ $categories->sum('recipes_count') }}
                    </div>
                    <div class="text-gray-600 font-medium">Total Recipes</div>
                </div>
                <div class="flex-1">
                    <div class="text-3xl font-bold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">
                        {{ $categories->where('recipes_count', '>', 0)->count() }}
                    </div>
                    <div class="text-gray-600 font-medium">Active Categories</div>
                </div>
            </div>
        </div>

        <!-- Categories Grid - 3 columns layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @foreach($categories as $index => $category)
                @php
                    $categoryConfigs = [
                        0 => [
                            'name' => 'breakfast',
                            'gradient' => 'from-amber-400 via-orange-400 to-yellow-500',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>',
                            'pattern' => 'data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="20" cy="20" r="4"/><circle cx="40" cy="40" r="6"/><circle cx="50" cy="10" r="3"/></g></svg>'
                        ],
                        1 => [
                            'name' => 'lunch',
                            'gradient' => 'from-emerald-400 via-green-400 to-teal-500',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4a2 2 0 012-2h8a2 2 0 012 2v2m-4 14v8m0-8V8m0 8h8m-8 0H4"/>',
                            'pattern' => 'data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><rect x="10" y="10" width="8" height="8"/><rect x="35" y="25" width="12" height="12"/><rect x="45" y="5" width="6" height="6"/></g></svg>'
                        ],
                        2 => [
                            'name' => 'dinner',
                            'gradient' => 'from-indigo-500 via-purple-500 to-pink-500',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>',
                            'pattern' => 'data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><polygon points="30,5 35,20 25,20"/><polygon points="15,35 25,45 10,45"/><polygon points="45,25 55,35 40,40"/></g></svg>'
                        ]
                    ];
                    $config = $categoryConfigs[$index % 3];
                @endphp

                <div class="group">
                    <div class="bg-white rounded-3xl overflow-hidden shadow-xl card-hover border border-gray-100/50">
                        <!-- Category Header with unique design for each meal -->
                        <div class="relative h-40 bg-gradient-to-br {{ $config['gradient'] }} overflow-hidden"
                             style="background-image: url('{{ $config['pattern'] }}');">
                            
                            <!-- Decorative elements -->
                            <div class="absolute inset-0 bg-gradient-to-br {{ $config['gradient'] }} opacity-90"></div>
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                            
                            <!-- Content -->
                            <div class="relative z-10 flex items-center justify-center h-full">
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-3 mx-auto shadow-lg">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $config['icon'] !!}
                                        </svg>
                                    </div>
                                    <div class="text-white/90 text-sm font-medium uppercase tracking-wider">
                                        {{ ucfirst($config['name']) }} Time
                                    </div>
                                </div>
                            </div>
                            
                            @auth
                                @if(auth()->user()->is_admin)
                                    <div class="absolute top-4 right-4 flex space-x-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                        <button onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')" 
                                                class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition-all duration-200 text-white shadow-lg"
                                                title="Edit Category">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline"
                                            onsubmit="return confirm('🗑️ Delete this category?\n\nThis action cannot be undone!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-red-500/70 transition-all duration-200 text-white shadow-lg"
                                                    title="Delete Category">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <!-- Card Content -->
                        <div class="p-8">
                            <!-- Title -->
                            <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-purple-600 transition-colors duration-300">
                                {{ $category->name }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-gray-600 mb-6 leading-relaxed line-height-relaxed">
                                {{ $category->description ?? 'Discover amazing recipes perfect for ' . $config['name'] . ' time.' }}
                            </p>
                            
                            <!-- Recipe Count with improved styling -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center text-gray-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span class="font-medium">{{ $category->recipes_count }} {{ Str::plural('recipe', $category->recipes_count) }}</span>
                                </div>
                                <div class="px-3 py-1 bg-gradient-to-r {{ $config['gradient'] }} rounded-full">
                                    <span class="text-white text-xs font-semibold uppercase tracking-wide">{{ ucfirst($config['name']) }}</span>
                                </div>
                            </div>
                            
                            <!-- Action Button -->
                            <a href="{{ route('categories.show', $category) }}"
                               class="block bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white text-center py-4 px-6 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-xl group-hover:shadow-2xl">
                                <span class="flex items-center justify-center">
                                    Explore Recipes
                                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="max-w-md mx-auto">
                <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-16 h-16 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">No Categories Yet</h3>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Recipe categories help organize your culinary collection. Start by creating your first category!
                </p>
                @auth
                    @if(auth()->user()->is_admin)
                        <button onclick="openCreateModal()" 
                               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold rounded-full transform hover:scale-105 transition-all duration-300 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Create Your First Category
                        </button>
                    @endif
                @endauth
            </div>
        </div>
    @endif
</div>

@auth
    @if(auth()->user()->is_admin)
        <!-- Create Category Modal -->
        <div id="createModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-800">Create New Category</h3>
                    <p class="text-gray-600 text-sm mt-1">Add a new recipe category to organize your collection</p>
                </div>
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="px-6 py-6">
                        <div class="mb-6">
                            <label for="create_name" class="block text-sm font-semibold text-gray-700 mb-2">Category Name</label>
                            <input type="text" id="create_name" name="name" required
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                   placeholder="e.g., Italian Cuisine, Desserts, Appetizers">
                        </div>
                        <div class="mb-6">
                            <label for="create_description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea id="create_description" name="description" rows="3"
                                      class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Describe what recipes belong in this category..."></textarea>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100 flex justify-end space-x-3">
                        <button type="button" onclick="closeCreateModal()" 
                                class="px-6 py-2 text-gray-600 hover:text-gray-800 font-medium rounded-xl hover:bg-gray-100 transition-all duration-200">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-6 py-2 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Category Modal -->
        <div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-800">Edit Category</h3>
                    <p class="text-gray-600 text-sm mt-1">Update category information</p>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-6">
                        <div class="mb-6">
                            <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-2">Category Name</label>
                            <input type="text" id="edit_name" name="name" required
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div class="mb-6">
                            <label for="edit_description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea id="edit_description" name="description" rows="3"
                                      class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"></textarea>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100 flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" 
                                class="px-6 py-2 text-gray-600 hover:text-gray-800 font-medium rounded-xl hover:bg-gray-100 transition-all duration-200">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-6 py-2 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endauth

<script>
function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
    document.getElementById('createModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
    document.getElementById('createModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
    // Clear form
    document.getElementById('create_name').value = '';
    document.getElementById('create_description').value = '';
}

function openEditModal(id, name, description) {
    document.getElementById('editForm').action = `/categories/${id}`;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description || '';
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Close modals when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('createModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeCreateModal();
    });

    document.getElementById('editModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateModal();
            closeEditModal();
        }
    });
});

// Add smooth scrolling and enhanced card hover effects
document.addEventListener('DOMContentLoaded', function() {
    // Add enhanced styling
    const style = document.createElement('style');
    style.textContent = `
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .glass-effect {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .line-height-relaxed {
            line-height: 1.7;
        }
        
        /* Enhanced gradient animations */
        .card-hover .bg-gradient-to-br {
            transition: all 0.4s ease;
        }
        
        /* Smooth hover transitions for buttons */
        .card-hover:hover .bg-gradient-to-r {
            box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.4);
        }
        
        /* Mobile responsive improvements */
        @media (max-width: 1024px) {
            .grid.lg\\:grid-cols-3 {
                grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection