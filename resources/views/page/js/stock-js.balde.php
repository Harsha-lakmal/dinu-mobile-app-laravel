<script>
    let stockData = [];
    let filteredStockData = [];
    let categories = [];

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
                Swal.fire({
                    icon: "error",
                    title: "Logout Failed",
                    text: "Something went wrong!"
                });
            }
        });
    }

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
            document.getElementById('stock_id').value = stockItem.id;
            document.getElementById('name').value = stockItem.name;
            document.getElementById('brand').value = stockItem.brand;
            document.getElementById('model').value = stockItem.model || '';
            document.getElementById('price').value = stockItem.price;
            document.getElementById('count').value = stockItem.count;
            document.getElementById('subCategory_id').value = stockItem.subCategory_id;
            document.getElementById('desc').value = stockItem.desc || '';

            document.getElementById('stockModal').classList.remove('hidden');
        });
    }

    function closeStockModal() {
        document.getElementById('stockModal').classList.add('hidden');
    }

    document.getElementById('stockForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveStockItem();
    });

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
                        dropdown.innerHTML = '<option value="">Select Subcategory</option>';

                        response.subCategories.forEach(function(category) {
                            const option = document.createElement('option');
                            option.value = category.id;
                            option.textContent = category.sub_title;
                            dropdown.appendChild(option);
                        });

                        const filterDropdown = document.getElementById('categoryFilter');
                        filterDropdown.innerHTML = '<option value="">All Subcategories</option>';
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

    function saveStockItem() {
        const formData = {
            name: document.getElementById('name').value,
            brand: document.getElementById('brand').value,
            model: document.getElementById('model').value,
            price: parseFloat(document.getElementById('price').value),
            count: parseInt(document.getElementById('count').value),
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
                console.error('Error:');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Operation failed!',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

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
                    data: JSON.stringify({
                        id: stockId
                    }),
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

    function fetchStockData() {
        populateCategoryDropdown();
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
                    stockData = response.data;
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

    function renderStockTable() {
        populateCategoryDropdown()
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
            const category = categories.find(cat => parseInt(cat.id) === parseInt(item.subCategory_id));
            console.log(categories);

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
                        ${item.stockNumber || 'N/A'}
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
                            <p class="text-xs text-red-500 mt-1">${item.stockNumber || 'N/A'}</p>
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

    function filterStock() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const categoryFilter = document.getElementById('categoryFilter').value;
        const statusFilter = document.getElementById('stockStatusFilter').value;

        filteredStockData = stockData.filter(item => {
            const matchesSearch = item.name.toLowerCase().includes(searchTerm) ||
                item.brand.toLowerCase().includes(searchTerm) ||
                (item.model && item.model.toLowerCase().includes(searchTerm)) ||
                (item.stockNumber && item.stockNumber.toLowerCase().includes(searchTerm));

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

    function clearFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('categoryFilter').value = '';
        document.getElementById('stockStatusFilter').value = '';
        filteredStockData = [...stockData];
        renderStockTable();
    }

    document.getElementById('stockModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeStockModal();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
     fetchStockData();     
      const user = JSON.parse(localStorage.getItem('userData'));
        if (user && user.name) {
            document.getElementById('userName').textContent = user.name;
        }

    });
</script><script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>