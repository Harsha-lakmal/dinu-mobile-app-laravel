<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .subcategory-item {
            transition: all 0.3s ease;
        }

        .subcategory-item:hover {
            transform: translateX(5px);
        }

        .active-subcategory {
            background-color: #f0f9ff;
            border-left: 3px solid #0ea5e9;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <div id="mobileSidebarOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 lg:hidden hidden"></div>

        <div id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 transition duration-200 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                <h1 class="text-xl font-bold text-gray-800">Dinu Mobile</h1>
                <button id="closeSidebar" class="lg:hidden text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @include('model.nav.nav')
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center">
                        <button id="openSidebar" class="lg:hidden text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h2 class="text-lg font-semibold text-gray-800">Categories</h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span id="userName" class="text-gray-700">Dinu</span>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium" onclick="logOut()">
                            Logout
                        </button>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-4 py-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
                            <p class="text-gray-600 mt-1">Manage your product categories and subcategories</p>
                        </div>
                        <div class="flex space-x-2 mt-4 md:mt-0">
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center" onclick="openCategoryModal()">
                                <i class="fas fa-plus mr-2"></i>
                                Add New Category
                            </button>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center" onclick="openSubCategoryModal()">
                                <i class="fas fa-plus mr-2"></i>
                                Add New Sub Category
                            </button>
                        </div>
                    </div>

                    <div id="categoryModal" class="fixed inset-0 bg-gray-800 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
                        <div class="relative top-10 mx-auto p-5 w-full max-w-md">
                            <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 hover:scale-100">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4">
                                    <h3 class="text-xl font-bold text-white text-center">Add New Category</h3>
                                </div>
                                <form id="categoryForm" class="p-6 space-y-5">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700" for="title">
                                            Title
                                        </label>
                                        <div class="relative">
                                            <input type="text" id="title" name="title"
                                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                                placeholder="Enter category title">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description Textarea -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700" for="decs">
                                            Description
                                        </label>
                                        <textarea id="decs" name="decs" rows="3"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white resize-none"
                                            placeholder="Enter category description"></textarea>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="flex justify-end space-x-3 pt-4">
                                        <button type="button" onclick="closeCategoryModal()"
                                            class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 shadow-md hover:shadow-lg">
                                            Save Category
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Structure for Sub Category -->
                    <div id="subCategoryModal" class="fixed inset-0 bg-gray-800 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
                        <div class="relative top-10 mx-auto p-5 w-full max-w-md">
                            <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 hover:scale-100">
                                <!-- Header -->
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4">
                                    <h3 class="text-xl font-bold text-white text-center">Add New Sub Category</h3>
                                </div>

                                <!-- Form -->
                                <form id="subCategoryForm" class="p-6 space-y-5">
                                    <!-- Category Selection -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700" for="category_id">
                                            Parent Category
                                        </label>
                                        <select id="category_id" name="category_id"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white">
                                            <option value="">Select a category</option>
                                        </select>
                                    </div>

                                    <!-- Sub Title Input -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700" for="sub_title">
                                            Sub Title
                                        </label>
                                        <div class="relative">
                                            <input type="text" id="sub_title" name="sub_title"
                                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                                placeholder="Enter sub category title">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description Textarea -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700" for="sub_desc">
                                            Description
                                        </label>
                                        <textarea id="sub_desc" name="sub_desc" rows="3"
                                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white resize-none"
                                            placeholder="Enter sub category description"></textarea>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="flex justify-end space-x-3 pt-4">
                                        <button type="button" onclick="closeSubCategoryModal()"
                                            class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 shadow-md hover:shadow-lg">
                                            Save Sub Category
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="loadingState" class="text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
                        <p class="mt-2 text-gray-600">Loading categories...</p>
                    </div>

                    <!-- Categories and Subcategories Section -->
                    <div id="categoriesSection" class="hidden">
                        <!-- Tabs for Categories and Subcategories -->
                        <div class="bg-white rounded-lg shadow mb-6">
                            <div class="border-b">
                                <nav class="flex -mb-px">
                                    <button id="categoriesTab" class="py-4 px-6 text-center border-b-2 border-indigo-500 font-medium text-indigo-600 flex-1">
                                        Categories
                                    </button>
                                    <button id="subcategoriesTab" class="py-4 px-6 text-center border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-1">
                                        Subcategories
                                    </button>
                                </nav>
                            </div>
                        </div>

                        <!-- Categories Grid -->
                        <div id="categoriesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Categories will be dynamically populated here -->
                        </div>

                        <!-- Subcategories List -->
                        <div id="subcategoriesList" class="hidden">
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800" id="subcategoryHeader">Subcategories</h3>
                                </div>
                                <div class="p-6" id="subcategoriesContainer">
                                    <!-- Subcategories will be dynamically populated here -->
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
                                    <p id="totalCategories" class="text-2xl font-semibold text-gray-900">0</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-box text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Total Subcategories</h3>
                                    <p id="totalSubcategories" class="text-2xl font-semibold text-gray-900">0</p>
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
                                    <p id="activePromotions" class="text-2xl font-semibold text-gray-900">0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
@include('page.js.categories-js')

</html>