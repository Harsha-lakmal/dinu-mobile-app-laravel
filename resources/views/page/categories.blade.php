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
                <i class="fas fa-user-circle mr-3"></i>
                <span>Profile</span>
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
                        <span id="userName" class="text-gray-700">Dinu</span>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium" onclick="logOut()">
                            Logout
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page content -->
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

                    <!-- Modal Structure for Category -->
                    <div id="categoryModal" class="fixed inset-0 bg-gray-800 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
                        <div class="relative top-10 mx-auto p-5 w-full max-w-md">
                            <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 hover:scale-100">
                                <!-- Header -->
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4">
                                    <h3 class="text-xl font-bold text-white text-center">Add New Category</h3>
                                </div>

                                <!-- Form -->
                                <form id="categoryForm" class="p-6 space-y-5">
                                    <!-- Title Input -->
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

    <script>
        // Store categories and subcategories data
        let categoriesData = [];
        let subcategoriesData = [];
        let currentCategoryId = null;

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

        // Tab switching functionality
        document.getElementById('categoriesTab').addEventListener('click', function() {
            showCategoriesTab();
        });

        document.getElementById('subcategoriesTab').addEventListener('click', function() {
            showSubcategoriesTab();
        });

        function showCategoriesTab() {
            document.getElementById('categoriesTab').classList.add('border-indigo-500', 'text-indigo-600');
            document.getElementById('categoriesTab').classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('subcategoriesTab').classList.add('border-transparent', 'text-gray-500');
            document.getElementById('subcategoriesTab').classList.remove('border-indigo-500', 'text-indigo-600');
            document.getElementById('categoriesGrid').classList.remove('hidden');
            document.getElementById('subcategoriesList').classList.add('hidden');
        }

        function showSubcategoriesTab() {
            document.getElementById('subcategoriesTab').classList.add('border-indigo-500', 'text-indigo-600');
            document.getElementById('subcategoriesTab').classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('categoriesTab').classList.add('border-transparent', 'text-gray-500');
            document.getElementById('categoriesTab').classList.remove('border-indigo-500', 'text-indigo-600');
            document.getElementById('categoriesGrid').classList.add('hidden');
            document.getElementById('subcategoriesList').classList.remove('hidden');
        }

        function logOut() {
            $.ajax({
                url: "{{ route('logout') }}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        icon: "success",
                        title: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect_url;
                    });
                },
                error: function(xhr) {
                    console.log(xhr);

                    Swal.fire({
                        icon: "error",
                        title: "Logout Failed",
                        text: "Something went wrong!"
                    });
                }
            });
        }

        // Category Modal Functions
        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        // Sub Category Modal Functions
        function openSubCategoryModal() {
            // Populate categories dropdown when opening modal
            populateCategoriesDropdown();
            document.getElementById('subCategoryModal').classList.remove('hidden');
        }

        function closeSubCategoryModal() {
            document.getElementById('subCategoryModal').classList.add('hidden');
        }

        // Form submission handling for Category
        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formDataCategory = {
                title: document.getElementById('title').value,
                decs: document.getElementById('decs').value,
            };

            saveCategory(formDataCategory);
        });

        function formDataCategoryClear() {
            document.getElementById("categoryForm").reset();
        }

        function formDataSubCategoryClear() {
            document.getElementById("subCategoryForm").reset();
        }

        // Form submission handling for Sub Category
        document.getElementById('subCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                category_id: document.getElementById('category_id').value,
                sub_title: document.getElementById('sub_title').value,
                sub_desc: document.getElementById('sub_desc').value,
            };

            // AJAX call to save data
            saveSubCategory(formData);
        });

        function saveCategory(formDataCategory) {
            $.ajax({
                url: "{{ route('categories.store') }}",
                type: 'POST',
                data: JSON.stringify(formDataCategory),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status = 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Category added successfully!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            closeCategoryModal();
                            formDataCategoryClear();
                            fetchAllData();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error adding category: ' + data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {


                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error adding category',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        function saveSubCategory(formData) {


            if (!formData.category_id) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please select a parent category',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $.ajax({
                url: "{{ route('subcategories.store') }}",
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status = 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Sub Category added successfully!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            closeSubCategoryModal();
                            formDataSubCategoryClear();
                            fetchAllData();

                        });
                    } else {

                        formDataSubCategoryClear();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error adding sub category: ' + data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {


                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error adding sub category',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Function to populate categories dropdown
        function populateCategoriesDropdown() {
            $.ajax({
                url: "{{ route('categories.fetch') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        let dropdown = document.getElementById('category_id');
                        dropdown.innerHTML = '<option value="">Select a category</option>';

                        data.categories.forEach(function(category) {
                            let option = document.createElement('option');
                            option.value = category.id;
                            option.textContent = category.title;
                            dropdown.appendChild(option);
                        });
                    } else {
                        console.error('Failed to fetch categories for dropdown');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);

                    console.error('Error fetching categories for dropdown:', error);
                }
            });
        }

        // Function to fetch all data (categories and subcategories)
        function fetchAllData() {
            // Show loading state
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('categoriesSection').classList.add('hidden');

            // Fetch categories
            $.ajax({
                url: "{{ route('categories.fetch') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(categoriesData) {


                    if (categoriesData) {


                        window.categoriesData = categoriesData.categories;



                        fetchSubcategories();
                    } else {
                        // Hide loading state and show error
                        document.getElementById('loadingState').classList.add('hidden');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: categoriesData.message || 'Something went wrong!',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Hide loading state
                    document.getElementById('loadingState').classList.add('hidden');

                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch categories',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Function to fetch subcategories
        function fetchSubcategories() {
            $.ajax({
                url: "{{ route('subcategories.fetch') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(subcategoriesData) {
                    // Hide loading state
                    document.getElementById('loadingState').classList.add('hidden');
                    document.getElementById('categoriesSection').classList.remove('hidden');

                    if (subcategoriesData.success) {


                        window.subcategoriesData = subcategoriesData.subCategories;




                        // Update statistics
                        document.getElementById('totalCategories').textContent = window.categoriesData.length;
                        document.getElementById('totalSubcategories').textContent = window.subcategoriesData.length;
                        document.getElementById('activePromotions').textContent = subcategoriesData.activePromotions || '0';


                        renderCategories();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: subcategoriesData.message || 'Something went wrong!',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Hide loading state
                    document.getElementById('loadingState').classList.add('hidden');

                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch subcategories',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Function to render categories
        function renderCategories() {
            let categoriesGrid = document.getElementById('categoriesGrid');
            categoriesGrid.innerHTML = '';

            // Map categories to cards
            window.categoriesData.forEach(function(categories) {



                const colorMap = {
                    'Electronics': {
                        bg: 'bg-blue-100',
                        text: 'text-blue-600',
                        icon: 'fas fa-laptop'
                    },
                    'Clothing': {
                        bg: 'bg-green-100',
                        text: 'text-green-600',
                        icon: 'fas fa-tshirt'
                    },
                    'Books': {
                        bg: 'bg-yellow-100',
                        text: 'text-yellow-600',
                        icon: 'fas fa-book'
                    },
                    'Home & Garden': {
                        bg: 'bg-purple-100',
                        text: 'text-purple-600',
                        icon: 'fas fa-home'
                    },
                    'Sports & Fitness': {
                        bg: 'bg-red-100',
                        text: 'text-red-600',
                        icon: 'fas fa-dumbbell'
                    },
                    'Automotive': {
                        bg: 'bg-indigo-100',
                        text: 'text-indigo-600',
                        icon: 'fas fa-car'
                    }
                };




                // Default color and icon
                let colorInfo = colorMap[categories.title] || {
                    bg: 'bg-gray-100',
                    text: 'text-gray-600',
                    icon: 'fas fa-tag'
                };



                // Count subcategories for this category
                const subcategoryCount = window.subcategoriesData.filter(sub => sub.categoires_id == categories.id).length;



                // Format the last updated date
                const lastUpdated = categories.updated_at ?
                    new Date(categories.updated_at).toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    }) :
                    'N/A';


                const categoryCard = document.createElement('div');
                categoryCard.className = 'bg-white rounded-lg shadow overflow-hidden transition-transform duration-200 hover:shadow-md hover:-translate-y-1 fade-in';
                categoryCard.innerHTML = `
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 ${colorInfo.bg} rounded-lg flex items-center justify-center">
                                <i class="${colorInfo.icon} ${colorInfo.text} text-xl"></i>
                            </div>
                            <div class="flex space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900" onclick="editCategory(${categories.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900" onclick="deleteCategory(${categories.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">${categories.title}</h3>
                        <p class="text-gray-600 text-sm mb-4">${categories.decs || 'No description available'}</p>
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <div>
                                <span>${subcategoryCount} subcategories</span>
                            </div>
                            <div>
                                <span>Last updated: ${lastUpdated}</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="w-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100 py-2 rounded-md text-sm font-medium transition-colors duration-200" 
                                onclick="viewSubcategories(${categories.id}, '${categories.title}')">
                                View Subcategories
                            </button>
                        </div>
                    </div>
                `;

                categoriesGrid.appendChild(categoryCard);
            });
        }

        function viewSubcategories(categoryId, categoryTitle) {
            currentCategoryId = categoryId;



            document.getElementById('subcategoryHeader').textContent = `Subcategories for ${categoryTitle}`;


            const categorySubcategories = window.subcategoriesData.filter(sub => sub.categoires_id == categoryId);

            renderSubcategories(categorySubcategories);


            showSubcategoriesTab();
        }

        function renderSubcategories(subcategories) {
            let subcategoriesContainer = document.getElementById('subcategoriesContainer');
            subcategoriesContainer.innerHTML = '';

            if (subcategories.length === 0) {
                subcategoriesContainer.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-folder-open text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No subcategories found for this category.</p>
                    </div>
                `;
                return;
            }

            // Create subcategory items
            subcategories.forEach(function(subcategory) {
                const subcategoryItem = document.createElement('div');
                subcategoryItem.className = 'subcategory-item bg-white border border-gray-200 rounded-lg p-4 mb-3';
                subcategoryItem.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-medium text-gray-800">${subcategory.sub_title}</h4>
                            <p class="text-sm text-gray-600 mt-1">${subcategory.desc || 'No description available'}</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="text-indigo-600 hover:text-indigo-900" onclick="editSubcategory(${subcategory.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-900" onclick="deleteSubcategory(${subcategory.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                subcategoriesContainer.appendChild(subcategoryItem);
            });
        }

        // Edit category function
        // Edit category function
        function editCategory(categoryId) {
            // Find the category from categoriesData
            const category = window.categoriesData.find(cat => cat.id === categoryId);

            if (!category) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Category not found!',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Create or show edit modal
            showEditCategoryModal(category);
        }

        // Edit subcategory function
        function editSubcategory(subcategoryId) {
            // Find the subcategory from subcategoriesData
            const subcategory = window.subcategoriesData.find(sub => sub.id === subcategoryId);

            if (!subcategory) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Subcategory not found!',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Create or show edit modal
            showEditSubcategoryModal(subcategory);
        }

        // Show edit category modal
        function showEditCategoryModal(category) {
            // Create modal HTML if it doesn't exist
            if (!document.getElementById('editCategoryModal')) {
                createEditCategoryModal();
            }

            // Populate form with category data
            document.getElementById('edit_category_id').value = category.id;
            document.getElementById('edit_title').value = category.title;
            document.getElementById('edit_decs').value = category.decs || '';

            // Show modal
            document.getElementById('editCategoryModal').classList.remove('hidden');
        }

        // Show edit subcategory modal
        function showEditSubcategoryModal(subcategory) {
            // Create modal HTML if it doesn't exist
            if (!document.getElementById('editSubCategoryModal')) {
                createEditSubcategoryModal();
            }

            // Populate categories dropdown first
            populateEditCategoriesDropdown().then(() => {
                // Populate form with subcategory data
                document.getElementById('edit_sub_category_id').value = subcategory.id;
                document.getElementById('edit_category_id_select').value = subcategory.categoires_id;
                document.getElementById('edit_sub_title').value = subcategory.sub_title;
                document.getElementById('edit_sub_desc').value = subcategory.desc || '';

                // Show modal
                document.getElementById('editSubCategoryModal').classList.remove('hidden');
            });
        }

        // Create edit category modal
        function createEditCategoryModal() {
            const modalHTML = `
        <div id="editCategoryModal" class="fixed inset-0 bg-gray-800 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
            <div class="relative top-10 mx-auto p-5 w-full max-w-md">
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 hover:scale-100">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4">
                        <h3 class="text-xl font-bold text-white text-center">Edit Category</h3>
                    </div>

                    <!-- Form -->
                    <form id="editCategoryForm" class="p-6 space-y-5">
                        <input type="hidden" id="edit_category_id" name="id">
                        
                        <!-- Title Input -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="edit_title">
                                Title
                            </label>
                            <div class="relative">
                                <input type="text" id="edit_title" name="title"
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
                            <label class="block text-sm font-semibold text-gray-700" for="edit_decs">
                                Description
                            </label>
                            <textarea id="edit_decs" name="decs" rows="3"
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white resize-none"
                                placeholder="Enter category description"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="closeEditCategoryModal()"
                                class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 shadow-md hover:shadow-lg">
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;

            document.body.insertAdjacentHTML('beforeend', modalHTML);

            // Add form submit event listener
            document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
                e.preventDefault();
                updateCategory();
            });

            // Close modal when clicking outside
            document.getElementById('editCategoryModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeEditCategoryModal();
                }
            });
        }

        // Create edit subcategory modal
        function createEditSubcategoryModal() {
            const modalHTML = `
        <div id="editSubCategoryModal" class="fixed inset-0 bg-gray-800 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
            <div class="relative top-10 mx-auto p-5 w-full max-w-md">
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 hover:scale-100">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4">
                        <h3 class="text-xl font-bold text-white text-center">Edit Sub Category</h3>
                    </div>

                    <!-- Form -->
                    <form id="editSubCategoryForm" class="p-6 space-y-5">
                        <input type="hidden" id="edit_sub_category_id" name="id">
                        
                        <!-- Category Selection -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="edit_category_id_select">
                                Parent Category
                            </label>
                            <select id="edit_category_id_select" name="category_id"
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white">
                                <option value="">Select a category</option>
                            </select>
                        </div>

                        <!-- Sub Title Input -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="edit_sub_title">
                                Sub Title
                            </label>
                            <div class="relative">
                                <input type="text" id="edit_sub_title" name="sub_title"
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
                            <label class="block text-sm font-semibold text-gray-700" for="edit_sub_desc">
                                Description
                            </label>
                            <textarea id="edit_sub_desc" name="sub_desc" rows="3"
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white resize-none"
                                placeholder="Enter sub category description"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="closeEditSubCategoryModal()"
                                class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 shadow-md hover:shadow-lg">
                                Update Sub Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;

            document.body.insertAdjacentHTML('beforeend', modalHTML);

            // Add form submit event listener
            document.getElementById('editSubCategoryForm').addEventListener('submit', function(e) {
                e.preventDefault();
                updateSubcategory();
            });

            // Close modal when clicking outside
            document.getElementById('editSubCategoryModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeEditSubCategoryModal();
                }
            });
        }

        // Populate categories dropdown for edit subcategory modal
        function populateEditCategoriesDropdown() {
            return new Promise((resolve, reject) => {
                let dropdown = document.getElementById('edit_category_id_select');
                dropdown.innerHTML = '<option value="">Select a category</option>';

                window.categoriesData.forEach(function(category) {
                    let option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.title;
                    dropdown.appendChild(option);
                });

                resolve();
            });
        }

        // Update category function
        function updateCategory() {
            const formData = {
                id: document.getElementById('edit_category_id').value,
                title: document.getElementById('edit_title').value,
                decs: document.getElementById('edit_decs').value
            };

            $.ajax({
                url: "{{ route('categories.update') }}",
                type: 'PUT',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Category updated successfully!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            closeEditCategoryModal();
                            fetchAllData();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error updating category: ' + data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error updating category',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Update subcategory function
        function updateSubcategory() {
            const formData = {
                id: document.getElementById('edit_sub_category_id').value,
                category_id: document.getElementById('edit_category_id_select').value,
                sub_title: document.getElementById('edit_sub_title').value,
                sub_desc: document.getElementById('edit_sub_desc').value
            };

            if (!formData.category_id) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please select a parent category',
                    confirmButtonText: 'OK'
                });
                return;
            }
            console.log(formData);
            

            $.ajax({
                url: "{{ route('subCategories.update') }}",
                type: 'PUT',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Subcategory updated successfully!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            closeEditSubCategoryModal();
                            fetchAllData();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error updating subcategory: ' + data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error updating subcategory',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Close modal functions
        function closeEditCategoryModal() {
            document.getElementById('editCategoryModal').classList.add('hidden');
        }

        function closeEditSubCategoryModal() {
            document.getElementById('editSubCategoryModal').classList.add('hidden');
        }

        // Delete category function
        function deleteCategory(categoryId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('categories.destroy') }}",
                        type: 'DELETE',
                        data: {
                            id: categoryId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Category has been deleted.',
                                    'success'
                                ).then(() => {
                                    fetchAllData();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete category.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                            console.log(xhr.responseText);
                        }
                    });

                }
            });
        }

        // Delete subcategory function
        function deleteSubcategory(subcategoryId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('subcategories.destroy') }}",
                        type: 'DELETE',
                        data: {
                            id: subcategoryId,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Subcategory has been deleted.',
                                    'success'
                                ).then(() => {
                                    fetchAllData(); // Refresh the data
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete subcategory.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'Failed to delete subcategory.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        // Close modals when clicking outside
        document.getElementById('categoryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCategoryModal();
            }
        });

        document.getElementById('subCategoryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSubCategoryModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            fetchAllData();
             const user = JSON.parse(localStorage.getItem('userData'));

    if (user && user.name) {
        document.getElementById('userName').textContent = user.name;
    }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>