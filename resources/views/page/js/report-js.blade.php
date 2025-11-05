 <script>
     let stockChart, distributionChart;
     let currentProductsData = [];

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

     document.getElementById('exportReportBtn').addEventListener('click', function(e) {
         e.stopPropagation();
         document.getElementById('exportDropdown').classList.toggle('show');
     });

     document.addEventListener('click', function() {
         document.getElementById('exportDropdown').classList.remove('show');
     });

     document.getElementById('exportPDF').addEventListener('click', function() {
         exportToPDF();
     });

     document.getElementById('exportExcel').addEventListener('click', function() {
         exportToExcel();
     });

     document.getElementById('exportCSV').addEventListener('click', function() {
         exportToCSV();
     });

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

     function updateCharts(products) {
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