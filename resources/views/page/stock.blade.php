<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .active-nav {
            background-color: #e0e7ff;
            color: #4f46e5;
            border-right: 2px solid #4f46e5;
        }
        .nav-item:hover {
            background-color: #f3f4f6;
        }
        .low-stock {
            color: #dc2626;
            font-weight: 600;
        }
        .medium-stock {
            color: #d97706;
            font-weight: 600;
        }
        .high-stock {
            color: #059669;
            font-weight: 600;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
                        <h2 class="text-lg font-semibold text-gray-800">Stock Management</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">John Doe</span>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium" onclick="logOut()">
                            Logout
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-4 py-6">
                    <!-- Stock Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Stock Overview</h1>
                            <p class="text-gray-600 mt-1">Manage and track your inventory</p>
                        </div>
                        <div class="flex space-x-3 mt-4 md:mt-0">
                            <button class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md flex items-center" onclick="clearFilters()">
                                <i class="fas fa-refresh mr-2"></i>
                                Clear Filters
                            </button>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center" onclick="openAddStockModal()">
                                <i class="fas fa-plus mr-2"></i>
                                Add New Item
                            </button>
                        </div>
                    </div>

                    <!-- Stock Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-boxes text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Total Items</h3>
                                    <p id="totalItems" class="text-2xl font-semibold text-gray-900">0</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">In Stock</h3>
                                    <p id="inStockItems" class="text-2xl font-semibold text-gray-900">0</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-red-100 text-red-600">
                                    <i class="fas fa-exclamation-triangle text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Low Stock</h3>
                                    <p id="lowStockItems" class="text-2xl font-semibold text-gray-900">0</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                    <i class="fas fa-times-circle text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Out of Stock</h3>
                                    <p id="outOfStockItems" class="text-2xl font-semibold text-gray-900">0</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Search products..." 
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    onkeyup="filterStock()">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                            <select id="categoryFilter" onchange="filterStock()"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Categories</option>
                            </select>
                            <select id="stockStatusFilter" onchange="filterStock()"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Status</option>
                                <option value="high">In Stock</option>
                                <option value="low">Low Stock</option>
                                <option value="out">Out of Stock</option>
                            </select>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="loadingState" class="text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
                        <p class="mt-2 text-gray-600">Loading stock data...</p>
                    </div>

                    <!-- Stock Table -->
                    <div id="stockTable" class="bg-white rounded-lg shadow overflow-hidden mb-6 hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">Current Stock</h3>
                            <div class="text-sm text-gray-600">
                                Showing <span id="showingCount">0</span> of <span id="totalCount">0</span> items
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand/Model</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Number</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="stockTableBody" class="bg-white divide-y divide-gray-200">
                                    <!-- Dynamic content will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Low Stock Alert Section -->
                    <div id="lowStockSection" class="bg-white rounded-lg shadow overflow-hidden hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                                Low Stock Alerts
                            </h3>
                        </div>
                        <div class="p-6">
                            <div id="lowStockAlerts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Low stock alerts will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add/Edit Stock Modal -->
    <div id="stockModal" class="fixed inset-0 bg-gray-800 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
        <div class="relative top-10 mx-auto p-5 w-full max-w-2xl">
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 hover:scale-100">
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4">
                    <h3 id="stockModalTitle" class="text-xl font-bold text-white text-center">Add New Stock Item</h3>
                </div>

                <!-- Form -->
                <form id="stockForm" class="p-6 space-y-5">
                    <input type="hidden" id="stock_id" name="id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="name">
                                Product Name *
                            </label>
                            <input type="text" id="name" name="name" required
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="Enter product name">
                        </div>

                        <!-- Brand -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="brand">
                                Brand *
                            </label>
                            <input type="text" id="brand" name="brand" required
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="Enter brand">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Model -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="model">
                                Model
                            </label>
                            <input type="text" id="model" name="model"
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="Enter model">
                        </div>

                        <!-- Price -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="price">
                                Price *
                            </label>
                            <input type="number" id="price" name="price" required step="0.01"
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="0.00">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Stock Count -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="count">
                                Stock Count *
                            </label>
                            <input type="number" id="count" name="count" required
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="0">
                        </div>

                        <!-- Stock Number -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="stockNumber">
                                Stock Number *
                            </label>
                            <input type="text" id="stockNumber" name="stockNumber" required
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="Enter stock number">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Subcategory -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="subCategory_id">
                             Sub   Category *
                            </label>
                            <select id="subCategory_id" name="subCategory_id" required
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="desc">
                            Description
                        </label>
                        <textarea id="desc" name="desc" rows="3"
                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white resize-none"
                            placeholder="Enter product description"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeStockModal()"
                            class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 shadow-md hover:shadow-lg">
                            Save Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let stockData = [];
        let filteredStockData = [];
        let categories = [];

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

        // Logout function
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

        // Stock Modal Functions
        function openAddStockModal() {
            document.getElementById('stockModalTitle').textContent = 'Add New Stock Item';
            document.getElementById('stockForm').reset();
            document.getElementById('stock_id').value = '';
            populateCategoryDropdown();
            document.getElementById('stockModal').classList.remove('hidden');
        }

        function openEditStockModal(stockId) {
            const stockItem = stockData.find(item => item.id === stockId);
            if (!stockItem) return;

            document.getElementById('stockModalTitle').textContent = 'Edit Stock Item';
            populateCategoryDropdown().then(() => {
                // Populate form data
                document.getElementById('stock_id').value = stockItem.id;
                document.getElementById('name').value = stockItem.name;
                document.getElementById('brand').value = stockItem.brand;
                document.getElementById('model').value = stockItem.model || '';
                document.getElementById('price').value = stockItem.price;
                document.getElementById('count').value = stockItem.count;
                document.getElementById('stockNumber').value = stockItem.stockNumber;
                document.getElementById('subCategory_id').value = stockItem.subCategory_id;
                document.getElementById('desc').value = stockItem.desc || '';

                document.getElementById('stockModal').classList.remove('hidden');
            });
        }

        function closeStockModal() {
            document.getElementById('stockModal').classList.add('hidden');
        }

        // Form submission handling
        document.getElementById('stockForm').addEventListener('submit', function(e) {
            e.preventDefault();
            saveStockItem();
        });

        // Populate category dropdown
        function populateCategoryDropdown() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "{{ route('subcategories.fetch') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            const dropdown = document.getElementById('subCategory_id');
                            dropdown.innerHTML = '<option value="">Select Category</option>';
                            
                            response.subCategories.forEach(function(category) {
                                const option = document.createElement('option');
                                option.value = category.id;
                                option.textContent = category.sub_title;
                                dropdown.appendChild(option);
                            });
                            
                            // Also populate filter dropdown
                            const filterDropdown = document.getElementById('categoryFilter');
                            filterDropdown.innerHTML = '<option value="">All Categories</option>';
                            response.subCategories.forEach(function(category) {
                                const option = document.createElement('option');
                                option.value = category.id;
                                option.textContent = category.sub_title;
                                filterDropdown.appendChild(option);
                            });
                            
                            categories = response.subCategories;
                            resolve();
                        } else {
                            console.error('Failed to fetch categories');
                            reject();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching categories:', error);
                        reject();
                    }
                });
            });
        }

        // Save stock item (add or update)
        function saveStockItem() {
            const formData = {
                name: document.getElementById('name').value,
                brand: document.getElementById('brand').value,
                model: document.getElementById('model').value,
                price: parseFloat(document.getElementById('price').value),
                count: parseInt(document.getElementById('count').value),
                stockNumber: document.getElementById('stockNumber').value,
                subCategory_id: document.getElementById('subCategory_id').value,
                desc: document.getElementById('desc').value
            };

            const stockId = document.getElementById('stock_id').value;
            const url = stockId ? "{{ route('stock.update') }}" : "{{ route('stock.save') }}";
            const method = stockId ? 'PUT' : 'POST';

            if (stockId) {
                formData.id = stockId;
            }

            $.ajax({
                url: url,
                type: method,
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: stockId ? 'Stock item updated successfully!' : 'Stock item added successfully!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            closeStockModal();
                            fetchStockData();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Operation failed!',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Operation failed!',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Delete stock item
        function deleteStockItem(stockId) {
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
                        url: "{{ route('stock.delete') }}",
                        type: 'DELETE',
                        data: JSON.stringify({ id: stockId }),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Stock item has been deleted.',
                                    'success'
                                ).then(() => {
                                    fetchStockData();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message || 'Failed to delete item.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'Failed to delete item.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        // Fetch all stock data
        function fetchStockData() {
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('stockTable').classList.add('hidden');
            document.getElementById('lowStockSection').classList.add('hidden');

            $.ajax({
                url: "{{ route('stock.fetch') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    document.getElementById('loadingState').classList.add('hidden');
                    
                    if (response.success) {
                        stockData = response.stock;
                        filteredStockData = [...stockData];
                        renderStockTable();
                        updateStatistics();
                        updateLowStockAlerts();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to fetch stock data',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    document.getElementById('loadingState').classList.add('hidden');
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch stock data',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Render stock table
        function renderStockTable() {
            const tableBody = document.getElementById('stockTableBody');
            tableBody.innerHTML = '';

            if (filteredStockData.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            No stock items found
                        </td>
                    </tr>
                `;
                document.getElementById('stockTable').classList.remove('hidden');
                return;
            }

            filteredStockData.forEach(function(item) {
                const category = categories.find(cat => cat.id === item.subCategory_id);
                const categoryName = category ? category.sub_title : 'Unknown';
                
                let statusClass = '';
                let statusText = '';
                
                if (item.count === 0) {
                    statusClass = 'bg-red-100 text-red-800';
                    statusText = 'Out of Stock';
                } else if (item.count <= 5) {
                    statusClass = 'bg-red-100 text-red-800';
                    statusText = 'Low Stock';
                } else if (item.count <= 15) {
                    statusClass = 'bg-yellow-100 text-yellow-800';
                    statusText = 'Medium Stock';
                } else {
                    statusClass = 'bg-green-100 text-green-800';
                    statusText = 'In Stock';
                }

                const row = document.createElement('tr');
                row.className = 'fade-in';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${item.name}</div>
                                <div class="text-sm text-gray-500">${item.desc || 'No description'}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${item.brand}</div>
                        <div class="text-sm text-gray-500">${item.model || 'N/A'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${categoryName}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">$${parseFloat(item.price).toFixed(2)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${item.count}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                            ${statusText}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${item.stockNumber}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-indigo-600 hover:text-indigo-900 mr-3" onclick="openEditStockModal(${item.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-900" onclick="deleteStockItem(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            document.getElementById('stockTable').classList.remove('hidden');
            document.getElementById('showingCount').textContent = filteredStockData.length;
            document.getElementById('totalCount').textContent = stockData.length;
        }

        // Update statistics
        function updateStatistics() {
            const totalItems = stockData.length;
            const inStockItems = stockData.filter(item => item.count > 15).length;
            const lowStockItems = stockData.filter(item => item.count > 0 && item.count <= 15).length;
            const outOfStockItems = stockData.filter(item => item.count === 0).length;

            document.getElementById('totalItems').textContent = totalItems;
            document.getElementById('inStockItems').textContent = inStockItems;
            document.getElementById('lowStockItems').textContent = lowStockItems;
            document.getElementById('outOfStockItems').textContent = outOfStockItems;
        }

        // Update low stock alerts
        function updateLowStockAlerts() {
            const lowStockItems = stockData.filter(item => item.count > 0 && item.count <= 5);
            const alertsContainer = document.getElementById('lowStockAlerts');
            
            alertsContainer.innerHTML = '';

            if (lowStockItems.length === 0) {
                document.getElementById('lowStockSection').classList.add('hidden');
                return;
            }

            lowStockItems.forEach(function(item) {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'border border-red-200 rounded-lg p-4 bg-red-50 fade-in';
                alertDiv.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-red-800">${item.name}</h4>
                            <p class="text-xs text-red-600 mt-1">Only ${item.count} left in stock</p>
                            <p class="text-xs text-red-500 mt-1">${item.stockNumber}</p>
                        </div>
                        <button class="text-red-700 hover:text-red-900" onclick="openEditStockModal(${item.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                `;
                alertsContainer.appendChild(alertDiv);
            });

            document.getElementById('lowStockSection').classList.remove('hidden');
        }

        // Filter stock data
        function filterStock() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryFilter = document.getElementById('categoryFilter').value;
            const statusFilter = document.getElementById('stockStatusFilter').value;

            filteredStockData = stockData.filter(item => {
                const matchesSearch = item.name.toLowerCase().includes(searchTerm) ||
                                    item.brand.toLowerCase().includes(searchTerm) ||
                                    item.model.toLowerCase().includes(searchTerm) ||
                                    item.stockNumber.toLowerCase().includes(searchTerm);
                
                const matchesCategory = !categoryFilter || item.subCategory_id == categoryFilter;
                
                let matchesStatus = true;
                if (statusFilter === 'high') {
                    matchesStatus = item.count > 15;
                } else if (statusFilter === 'low') {
                    matchesStatus = item.count > 0 && item.count <= 15;
                } else if (statusFilter === 'out') {
                    matchesStatus = item.count === 0;
                }

                return matchesSearch && matchesCategory && matchesStatus;
            });

            renderStockTable();
        }

        // Clear filters
        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('categoryFilter').value = '';
            document.getElementById('stockStatusFilter').value = '';
            filteredStockData = [...stockData];
            renderStockTable();
        }

        // Close modal when clicking outside
        document.getElementById('stockModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStockModal();
            }
        });

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            fetchStockData();
        });
    </script>
</body>
</html>