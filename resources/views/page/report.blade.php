<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            <!-- Page content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-4 py-6">
                    <!-- Reports Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Reports & Analytics</h1>
                            <p class="text-gray-600 mt-1">Comprehensive insights and performance metrics</p>
                        </div>
                        <div class="flex space-x-3 mt-4 md:mt-0">
                            <button class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Last 30 Days
                            </button>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                                <i class="fas fa-download mr-2"></i>
                                Export Report
                            </button>
                        </div>
                    </div>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Total Revenue</h3>
                                    <p class="text-2xl font-semibold text-gray-900">$24,568</p>
                                    <p class="text-sm text-green-600 flex items-center mt-1">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        12.5% from last month
                                    </p>
                                </div>
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-dollar-sign text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Total Orders</h3>
                                    <p class="text-2xl font-semibold text-gray-900">1,248</p>
                                    <p class="text-sm text-green-600 flex items-center mt-1">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        8.3% from last month
                                    </p>
                                </div>
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-shopping-cart text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">New Customers</h3>
                                    <p class="text-2xl font-semibold text-gray-900">324</p>
                                    <p class="text-sm text-green-600 flex items-center mt-1">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        5.2% from last month
                                    </p>
                                </div>
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <i class="fas fa-users text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Conversion Rate</h3>
                                    <p class="text-2xl font-semibold text-gray-900">3.24%</p>
                                    <p class="text-sm text-red-600 flex items-center mt-1">
                                        <i class="fas fa-arrow-down mr-1"></i>
                                        1.2% from last month
                                    </p>
                                </div>
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                    <i class="fas fa-chart-line text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <!-- Revenue Chart -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-medium text-gray-900">Revenue Overview</h3>
                                <select class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option>Last 7 Days</option>
                                    <option selected>Last 30 Days</option>
                                    <option>Last 90 Days</option>
                                </select>
                            </div>
                            <div class="h-64">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>

                        <!-- Sales Chart -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-medium text-gray-900">Sales by Category</h3>
                                <select class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option>Last 7 Days</option>
                                    <option selected>Last 30 Days</option>
                                    <option>Last 90 Days</option>
                                </select>
                            </div>
                            <div class="h-64">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Reports -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Top Products -->
                        <div class="bg-white rounded-lg shadow lg:col-span-2">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Top Performing Products</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sales</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-laptop text-blue-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">MacBook Pro 16"</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Electronics</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">48 units</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">$86,400</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-tshirt text-green-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">Cotton T-Shirt</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Clothing</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">156 units</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">$2,340</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-book text-yellow-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">JavaScript Guide</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Books</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">89 units</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">$1,780</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-couch text-purple-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">Leather Sofa</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Furniture</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12 units</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">$23,400</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Report Types -->
                        <div class="bg-white rounded-lg shadow">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Quick Reports</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <button class="w-full text-left p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Sales Report</h4>
                                            <p class="text-sm text-gray-500 mt-1">Detailed sales analysis</p>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    </div>
                                </button>
                                <button class="w-full text-left p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Inventory Report</h4>
                                            <p class="text-sm text-gray-500 mt-1">Stock levels and alerts</p>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    </div>
                                </button>
                                <button class="w-full text-left p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Customer Report</h4>
                                            <p class="text-sm text-gray-500 mt-1">Customer behavior insights</p>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    </div>
                                </button>
                                <button class="w-full text-left p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Financial Report</h4>
                                            <p class="text-sm text-gray-500 mt-1">Revenue and expenses</p>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Metrics -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Performance Metrics</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Website Traffic</h4>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="progress-bar h-2 rounded-full" style="width: 75%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">12,458 visits (75% of target)</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Order Completion</h4>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="progress-bar h-2 rounded-full" style="width: 68%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">68% success rate</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Customer Satisfaction</h4>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="progress-bar h-2 rounded-full" style="width: 92%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">4.6/5 average rating</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Inventory Turnover</h4>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="progress-bar h-2 rounded-full" style="width: 58%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">58% monthly turnover</p>
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

        // Charts
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 19000, 15000, 25000, 22000, 30000, 24568],
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Electronics', 'Clothing', 'Books', 'Furniture', 'Sports'],
                datasets: [{
                    data: [35, 25, 15, 15, 10],
                    backgroundColor: [
                        '#4f46e5',
                        '#10b981',
                        '#f59e0b',
                        '#8b5cf6',
                        '#ef4444'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>