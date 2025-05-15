
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cookbook | Recipes</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    <!-- Heroicons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F9FAFB;
        }
        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="ml-2 text-xl font-bold text-gray-800">MyCookbook</span>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="#" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Recipes
                            </a>
                            <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Categories
                            </a>
                            <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Favorites
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add New Recipe
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Header with search -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">My Recipes</h1>
                <div class="mt-4 md:mt-0">
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search recipes...">
                    </div>
                </div>
            </div>

            <!-- Recipe grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Recipe Card 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md transition-all duration-300 recipe-card">
                    <div class="relative pb-2/3">
                        <img class="absolute h-full w-full object-cover" src="/api/placeholder/400/200" alt="Recipe image">
                        <div class="absolute top-0 right-0 mt-2 mr-2">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Easy</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-1">Nostrum voluptatem quia</h2>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">Quia voluptatem quidem optio quia animi voluptas aut porro. Odio molestiae cumque quae ut sapiente.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>52 mins</span>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View Details →</a>
                        </div>
                    </div>
                </div>

                <!-- Recipe Card 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md transition-all duration-300 recipe-card">
                    <div class="relative pb-2/3">
                        <img class="absolute h-full w-full object-cover" src="/api/placeholder/400/200" alt="Recipe image">
                        <div class="absolute top-0 right-0 mt-2 mr-2">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Medium</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-1">Id ut provident</h2>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">Placeat harum voluptate eos. Odit iste quidem sequi sequi maxime at. Atque eveniet cum ipsa commodi...</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>111 mins</span>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View Details →</a>
                        </div>
                    </div>
                </div>

                <!-- Recipe Card 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md transition-all duration-300 recipe-card">
                    <div class="relative pb-2/3">
                        <img class="absolute h-full w-full object-cover" src="/api/placeholder/400/200" alt="Recipe image">
                        <div class="absolute top-0 right-0 mt-2 mr-2">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Medium</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-1">Non est ut</h2>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">Hic reiciendis dolorum veritatis eum. Laudantium quidem alias odit omnis ipsum dolores provident cor...</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>142 mins</span>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View Details →</a>
                        </div>
                    </div>
                </div>

                <!-- Recipe Card 4 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md transition-all duration-300 recipe-card">
                    <div class="relative pb-2/3">
                        <img class="absolute h-full w-full object-cover" src="/api/placeholder/400/200" alt="Recipe image">
                        <div class="absolute top-0 right-0 mt-2 mr-2">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Medium</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-1">Quia sed omnis corporis</h2>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">Sit assumenda sint eum voluptatibus. Et est ea aut voluptatem cupiditate et ut. Consectetur repellen...</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>109 mins</span>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View Details →</a>
                        </div>
                    </div>
                </div>

                <!-- Recipe Card 5 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md transition-all duration-300 recipe-card">
                    <div class="relative pb-2/3">
                        <img class="absolute h-full w-full object-cover" src="/api/placeholder/400/200" alt="Recipe image">
                        <div class="absolute top-0 right-0 mt-2 mr-2">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Medium</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-1">Ipsa ut ratione quis</h2>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">Magni nam ut dolores porro. Minima aut nostrum quod aliquam minus voluptates nam consequatur. Consec...</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>135 mins</span>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View Details →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-indigo-600 hover:bg-gray-50">1</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</a>
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-50 text-sm font-medium text-gray-700">...</span>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">8</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">9</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">10</a>
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </nav>
            </div>
        </main>
    </div>

    <script>
        // Initialize Feather icons
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();
        });
    </script>
</body>
</html>