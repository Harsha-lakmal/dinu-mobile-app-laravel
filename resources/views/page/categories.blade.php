<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .active-category {
            background-color: #e0e7ff;
            color: #4f46e5;
            border-right: 2px solid #4f46e5;
        }
        .category-item:hover {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Mobile sidebar overlay -->
        <div id="mobileSidebarOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 lg:hidden hidden"></div>

        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 transition duration-200 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
                <button id="closeSidebar" class="lg:hidden text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('stock') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->is('page1') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
                    <i class="fas fa-chart-bar mr-3"></i>
                    <span>Stock</span>
                </a>
                 <a href="{{ route('reports') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->is('page4') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
                    <i class="fas fa-file-alt mr-3"></i>
                    <span>Reports</span>
                </a>

                 <a href="{{ route('categories') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->is('page4') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
                    <i class="fas fa-file-alt mr-3"></i>
                    <span>Categories</span>
                </a>
                
                <a href="{{ route('users') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->is('page2') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
                    <i class="fas fa-users mr-3"></i>
                    <span>Users</span>
                </a>
                
                <a href="{{ route('settings') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->is('page3') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
                    <i class="fas fa-cog mr-3"></i>
                    <span>Settings</span>
                </a>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center">
                        <button id="openSidebar" class="lg:hidden text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h2 class="text-lg font-semibold text-gray-800">Categories</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">John Doe</span>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Logout
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-4 py-6">
                    <!-- Categories Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
                            <p class="text-gray-600 mt-1">Manage your product categories</p>
                        </div>
                        <button class="mt-4 md:mt-0 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Category
                        </button>
                    </div>

                    <!-- Categories Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Category Card 1 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden transition-transform duration-200 hover:shadow-md hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-laptop text-blue-600 text-xl"></i>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Electronics</h3>
                                <p class="text-gray-600 text-sm mb-4">Laptops, smartphones, tablets and accessories</p>
                                <div class="flex justify-between text-sm text-gray-500">
                                    <span>24 products</span>
                                    <span>Last updated: 2 days ago</span>
                                </div>
                            </div>
                        </div>

                        <!-- Category Card 2 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden transition-transform duration-200 hover:shadow-md hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-tshirt text-green-600 text-xl"></i>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Clothing</h3>
                                <p class="text-gray-600 text-sm mb-4">Men's, women's and children's apparel</p>
                                <div class="flex justify-between text-sm text-gray-500">
                                    <span>156 products</span>
                                    <span>Last updated: 1 day ago</span>
                                </div>
                            </div>
                        </div>

                        <!-- Category Card 3 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden transition-transform duration-200 hover:shadow-md hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-book text-yellow-600 text-xl"></i>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Books</h3>
                                <p class="text-gray-600 text-sm mb-4">Fiction, non-fiction, educational materials</p>
                                <div class="flex justify-between text-sm text-gray-500">
                                    <span>89 products</span>
                                    <span>Last updated: 5 days ago</span>
                                </div>
                            </div>
                        </div>

                        <!-- Category Card 4 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden transition-transform duration-200 hover:shadow-md hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-home text-purple-600 text-xl"></i>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Home & Garden</h3>
                                <p class="text-gray-600 text-sm mb-4">Furniture, decor, kitchen and garden items</p>
                                <div class="flex justify-between text-sm text-gray-500">
                                    <span>67 products</span>
                                    <span>Last updated: 3 days ago</span>
                                </div>
                            </div>
                        </div>

                        <!-- Category Card 5 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden transition-transform duration-200 hover:shadow-md hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-dumbbell text-red-600 text-xl"></i>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Sports & Fitness</h3>
                                <p class="text-gray-600 text-sm mb-4">Exercise equipment, sportswear, accessories</p>
                                <div class="flex justify-between text-sm text-gray-500">
                                    <span>42 products</span>
                                    <span>Last updated: 1 week ago</span>
                                </div>
                            </div>
                        </div>

                        <!-- Category Card 6 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden transition-transform duration-200 hover:shadow-md hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-car text-indigo-600 text-xl"></i>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Automotive</h3>
                                <p class="text-gray-600 text-sm mb-4">Car parts, accessories, maintenance items</p>
                                <div class="flex justify-between text-sm text-gray-500">
                                    <span>31 products</span>
                                    <span>Last updated: 2 weeks ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Section -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-list text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Total Categories</h3>
                                    <p class="text-2xl font-semibold text-gray-900">12</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-box text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Total Products</h3>
                                    <p class="text-2xl font-semibold text-gray-900">409</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                    <i class="fas fa-tags text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Active Promotions</h3>
                                    <p class="text-2xl font-semibold text-gray-900">5</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Mobile sidebar functionality
        document.getElementById('openSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('mobileSidebarOverlay').classList.remove('hidden');
        });

        document.getElementById('closeSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('mobileSidebarOverlay').classList.add('hidden');
        });

        document.getElementById('mobileSidebarOverlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            this.classList.add('hidden');
        });
    </script>
</body>
</html>