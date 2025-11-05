<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        .active-nav {
            background-color: #e0e7ff;
            color: #4f46e5;
            border-right: 2px solid #4f46e5;
        }

        .nav-item:hover {
            background-color: #f3f4f6;
        }

        .progress-bar {
            background: linear-gradient(90deg, #4f46e5 0%, #8b5cf6 100%);
        }

        .export-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 50;
            min-width: 200px;
        }

        .export-dropdown.show {
            display: block;
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
                        <h2 class="text-lg font-semibold text-gray-800">Reports & Analytics</h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span id="userName" class="text-gray-700">John Doe</span>

                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Logout
                        </button>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-4 py-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Reports & Analytics</h1>
                            <p class="text-gray-600 mt-1">Comprehensive insights and performance metrics</p>
                        </div>
                        <div class="flex space-x-3 mt-4 md:mt-0 relative">
                            <button class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Last 30 Days
                            </button>
                            <div class="relative">
                                <button id="exportReportBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                                    <i class="fas fa-download mr-2"></i>
                                    Export Report
                                </button>
                                <div id="exportDropdown" class="export-dropdown">
                                    <button id="exportPDF" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fas fa-file-pdf mr-2 text-red-500"></i>
                                        Export as PDF
                                    </button>
                                    <button id="exportExcel" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fas fa-file-excel mr-2 text-green-500"></i>
                                        Export as Excel
                                    </button>
                                    <button id="exportCSV" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fas fa-file-csv mr-2 text-blue-500"></i>
                                        Export as CSV
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Total Products</h3>
                                    <p id="totalProducts" class="text-2xl font-semibold text-gray-900">Loading...</p>
                                    <p class="text-sm text-gray-600 mt-1">Items in stock</p>
                                </div>
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-boxes text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Total Value</h3>
                                    <p id="totalValue" class="text-2xl font-semibold text-gray-900">Loading...</p>
                                    <p class="text-sm text-gray-600 mt-1">Inventory worth</p>
                                </div>
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-dollar-sign text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Low Stock Items</h3>
                                    <p id="lowStockCount" class="text-2xl font-semibold text-gray-900">Loading...</p>
                                    <p class="text-sm text-gray-600 mt-1">Need restocking</p>
                                </div>
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                    <i class="fas fa-exclamation-triangle text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Categories</h3>
                                    <p id="categoryCount" class="text-2xl font-semibold text-gray-900">Loading...</p>
                                    <p class="text-sm text-gray-600 mt-1">Product categories</p>
                                </div>
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <i class="fas fa-tags text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-medium text-gray-900">Stock Value by Category</h3>
                            </div>
                            <div class="h-64">
                                <canvas id="stockChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-medium text-gray-900">Stock Distribution</h3>
                            </div>
                            <div class="h-64">
                                <canvas id="distributionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div id="productsSection" class="bg-white rounded-lg shadow mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">All Products</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table id="productsTable" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand/Model</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Value</th>
                                    </tr>
                                </thead>
                                <tbody id="productsTableBody" class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Loading products...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
@include('page.js.report-js')

</html>