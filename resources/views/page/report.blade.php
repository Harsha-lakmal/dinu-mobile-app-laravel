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

                    <!-- Key Metrics -->
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

                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <!-- Stock Value Chart -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-medium text-gray-900">Stock Value by Category</h3>
                            </div>
                            <div class="h-64">
                                <canvas id="stockChart"></canvas>
                            </div>
                        </div>

                        <!-- Stock Distribution Chart -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-medium text-gray-900">Stock Distribution</h3>
                            </div>
                            <div class="h-64">
                                <canvas id="distributionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Products Table -->
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

    <script>
        // Global variables
        let stockChart, distributionChart;
        let currentProductsData = [];

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

        // Export dropdown functionality
        document.getElementById('exportReportBtn').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('exportDropdown').classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            document.getElementById('exportDropdown').classList.remove('show');
        });

        // Export functionality
        document.getElementById('exportPDF').addEventListener('click', function() {
            exportToPDF();
        });

        document.getElementById('exportExcel').addEventListener('click', function() {
            exportToExcel();
        });

        document.getElementById('exportCSV').addEventListener('click', function() {
            exportToCSV();
        });

        // Function to get reports data
        function getReportsData() {
            $.ajax({
                url: "{{ route('get.all') }}",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        currentProductsData = response.data;
                        displayProductsData(response.data);
                        updateMetrics(response.data);
                        updateCharts(response.data);
                    } else {
                        console.error("Error fetching data:", response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    document.getElementById('productsTableBody').innerHTML =
                        '<tr><td colspan="6" class="px-6 py-4 text-center text-red-500">Error loading data</td></tr>';
                }
            });
        }

        // Function to display products in table
        function displayProductsData(products) {
            const tbody = document.getElementById('productsTableBody');

            if (products.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No products found</td></tr>';
                return;
            }

            let html = '';
            products.forEach(product => {
                const stockValue = (parseFloat(product.price) * parseInt(product.count)).toFixed(2);
                const stockClass = product.count <= 5 ? 'text-red-600 font-semibold' : 'text-gray-900';

                html += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-box text-indigo-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">${product.name}</div>
                                    <div class="text-sm text-gray-500">${product.stockNumber}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${product.brand}</div>
                            <div class="text-sm text-gray-500">${product.model}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${product.category_name} / ${product.sub_category_name}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            $${parseFloat(product.price).toFixed(2)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm ${stockClass}">${product.count} units</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            $${stockValue}
                        </td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
        }

        // Function to update metrics
        function updateMetrics(products) {
            let totalProducts = products.length;
            let totalValue = 0;
            let lowStockCount = 0;
            let categories = new Set();

            products.forEach(product => {
                totalValue += parseFloat(product.price) * parseInt(product.count);
                if (parseInt(product.count) <= 5) {
                    lowStockCount++;
                }
                categories.add(product.category_name);
            });

            document.getElementById('totalProducts').textContent = totalProducts;
            document.getElementById('totalValue').textContent = '$' + totalValue.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById('lowStockCount').textContent = lowStockCount;
            document.getElementById('categoryCount').textContent = categories.size;
        }

        // Function to update charts
        function updateCharts(products) {
            // Group by category
            const categoryData = {};
            const categoryCount = {};

            products.forEach(product => {
                const category = product.category_name;
                const value = parseFloat(product.price) * parseInt(product.count);

                if (!categoryData[category]) {
                    categoryData[category] = 0;
                    categoryCount[category] = 0;
                }

                categoryData[category] += value;
                categoryCount[category] += parseInt(product.count);
            });

            const categories = Object.keys(categoryData);
            const values = Object.values(categoryData);
            const counts = Object.values(categoryCount);

            // Stock Value Chart
            const stockCtx = document.getElementById('stockChart').getContext('2d');
            if (stockChart) {
                stockChart.destroy();
            }
            stockChart = new Chart(stockCtx, {
                type: 'bar',
                data: {
                    labels: categories,
                    datasets: [{
                        label: 'Stock Value ($)',
                        data: values,
                        backgroundColor: '#4f46e5',
                        borderColor: '#4f46e5',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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

            // Distribution Chart
            const distributionCtx = document.getElementById('distributionChart').getContext('2d');
            if (distributionChart) {
                distributionChart.destroy();
            }
            distributionChart = new Chart(distributionCtx, {
                type: 'doughnut',
                data: {
                    labels: categories,
                    datasets: [{
                        data: counts,
                        backgroundColor: [
                            '#4f46e5',
                            '#10b981',
                            '#f59e0b',
                            '#8b5cf6',
                            '#ef4444',
                            '#06b6d4',
                            '#f97316'
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
        }

        function exportToPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            doc.setFontSize(20);
            doc.text('Inventory Report', 105, 15, {
                align: 'center'
            });

            doc.setFontSize(10);
            doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 105, 22, {
                align: 'center'
            });

            doc.setFontSize(12);
            doc.text(`Total Products: ${document.getElementById('totalProducts').textContent}`, 20, 35);
            doc.text(`Total Inventory Value: ${document.getElementById('totalValue').textContent}`, 20, 42);
            doc.text(`Low Stock Items: ${document.getElementById('lowStockCount').textContent}`, 20, 49);
            doc.text(`Categories: ${document.getElementById('categoryCount').textContent}`, 20, 56);

            let yPosition = 70;
            doc.setFontSize(10);
            doc.text('Product Name', 20, yPosition);
            doc.text('Brand/Model', 60, yPosition);
            doc.text('Category', 100, yPosition);
            doc.text('Price', 130, yPosition);
            doc.text('Stock', 150, yPosition);
            doc.text('Value', 170, yPosition);

            yPosition += 7;
            doc.line(20, yPosition, 190, yPosition);
            yPosition += 5;

            doc.setFontSize(8);
            currentProductsData.forEach(product => {
                if (yPosition > 270) {
                    doc.addPage();
                    yPosition = 20;
                }

                const stockValue = (parseFloat(product.price) * parseInt(product.count)).toFixed(2);

                doc.text(product.name.substring(0, 20), 20, yPosition);
                doc.text(`${product.brand}/${product.model}`.substring(0, 15), 60, yPosition);
                doc.text(`${product.category_name}`.substring(0, 15), 100, yPosition);
                doc.text(`$${parseFloat(product.price).toFixed(2)}`, 130, yPosition);
                doc.text(product.count, 150, yPosition);
                doc.text(`$${stockValue}`, 170, yPosition);

                yPosition += 6;
            });

            doc.save(`inventory-report-${new Date().toISOString().split('T')[0]}.pdf`);
        }

        function exportToExcel() {
            const excelData = currentProductsData.map(product => {
                const stockValue = (parseFloat(product.price) * parseInt(product.count)).toFixed(2);
                return {
                    'Product Name': product.name,
                    'Stock Number': product.stockNumber,
                    'Brand': product.brand,
                    'Model': product.model,
                    'Category': product.category_name,
                    'Sub Category': product.sub_category_name,
                    'Price': parseFloat(product.price),
                    'Stock Count': parseInt(product.count),
                    'Stock Value': parseFloat(stockValue),
                    'Description': product.desc
                };
            });

            const totalValue = currentProductsData.reduce((sum, product) =>
                sum + (parseFloat(product.price) * parseInt(product.count)), 0);
            const lowStockCount = currentProductsData.filter(product => parseInt(product.count) <= 5).length;
            const categories = new Set(currentProductsData.map(product => product.category_name)).size;

            const summaryData = [{},
                {
                    'Product Name': 'SUMMARY',
                    'Stock Count': currentProductsData.length,
                    'Stock Value': totalValue,
                    'Description': `Categories: ${categories}, Low Stock Items: ${lowStockCount}`
                },
                {},
                ...excelData
            ];

            const ws = XLSX.utils.json_to_sheet(summaryData, {
                skipHeader: false
            });

            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Inventory Report');

            XLSX.writeFile(wb, `inventory-report-${new Date().toISOString().split('T')[0]}.xlsx`);
        }

        function exportToCSV() {
            const headers = ['Product Name', 'Stock Number', 'Brand', 'Model', 'Category', 'Sub Category', 'Price', 'Stock Count', 'Stock Value', 'Description'];

            const csvData = currentProductsData.map(product => {
                const stockValue = (parseFloat(product.price) * parseInt(product.count)).toFixed(2);
                return [
                    `"${product.name}"`,
                    `"${product.stockNumber}"`,
                    `"${product.brand}"`,
                    `"${product.model}"`,
                    `"${product.category_name}"`,
                    `"${product.sub_category_name}"`,
                    parseFloat(product.price).toFixed(2),
                    product.count,
                    stockValue,
                    `"${product.desc}"`
                ];
            });

            const totalValue = currentProductsData.reduce((sum, product) =>
                sum + (parseFloat(product.price) * parseInt(product.count)), 0);
            const lowStockCount = currentProductsData.filter(product => parseInt(product.count) <= 5).length;
            const categories = new Set(currentProductsData.map(product => product.category_name)).size;

            const summaryRow = [
                'SUMMARY', '', '', '', '', '', '',
                currentProductsData.length,
                totalValue.toFixed(2),
                `Categories: ${categories}, Low Stock Items: ${lowStockCount}`
            ];

            const allData = [headers, summaryRow, [], ...csvData];

            const csvString = allData.map(row => row.join(',')).join('\n');

            const blob = new Blob([csvString], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `inventory-report-${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        $(document).ready(function() {
            getReportsData();

            const user = JSON.parse(localStorage.getItem('userData'));

            if (user && user.name) {
                document.getElementById('userName').textContent = user.name;
            }
        });
    </script>
</body>

</html>