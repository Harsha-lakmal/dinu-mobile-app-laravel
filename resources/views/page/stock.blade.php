<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Page </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

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
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <div id="mobileSidebarOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 lg:hidden hidden"></div>

        <div id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 transition duration-200 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                <h1 class="text-xl font-bold text-gray-800">Dinu Mobile </h1>
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
                        <h2 class="text-lg font-semibold text-gray-800">Stock Page </h2>
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
                                <option value="">All Subcategories</option>
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

                    <div id="loadingState" class="text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
                        <p class="mt-2 text-gray-600">Loading stock data...</p>
                    </div>

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
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subcategory</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Number</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="stockTableBody" class="bg-white divide-y divide-gray-200">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="lowStockSection" class="bg-white rounded-lg shadow overflow-hidden hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                                Low Stock Alerts
                            </h3>
                        </div>
                        <div class="p-6">
                            <div id="lowStockAlerts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="stockModal" class="fixed inset-0 bg-gray-800 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
        <div class="relative top-10 mx-auto p-5 w-full max-w-2xl">
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 hover:scale-100">

            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4">
                    <h3 id="stockModalTitle" class="text-xl font-bold text-white text-center">Add New Stock Item</h3>
                </div>
                <form id="stockForm" class="p-6 space-y-5">
                    <input type="hidden" id="stock_id" name="id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="name">
                                Product Name *
                            </label>
                            <input type="text" id="name" name="name" required
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="Enter product name">
                        </div>

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
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="model">
                                Model
                            </label>
                            <input type="text" id="model" name="model"
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="Enter model">
                        </div>

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
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="count">
                                Stock Count *
                            </label>
                            <input type="number" id="count" name="count" required
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="0">
                        </div>

                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="subCategory_id">
                                Sub Category *
                            </label>
                            <select id="subCategory_id" name="subCategory_id" required
                                class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white">
                                <option value="">Select Subcategory</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="desc">
                            Description
                        </label>
                        <textarea id="desc" name="desc" rows="3"
                            class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white resize-none"
                            placeholder="Enter product description"></textarea>
                    </div>

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
   @yield('scripts')
</body> 
@include('page.js.stock-js')
</html>