<script>
    let categoriesData = [];
    let subcategoriesData = [];
    let currentCategoryId = null;

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

    function openCategoryModal() {
        document.getElementById('categoryModal').classList.remove('hidden');
    }

    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
    }

    function openSubCategoryModal() {
        populateCategoriesDropdown();
        document.getElementById('subCategoryModal').classList.remove('hidden');
    }

    function closeSubCategoryModal() {
        document.getElementById('subCategoryModal').classList.add('hidden');
    }

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

    document.getElementById('subCategoryForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = {
            category_id: document.getElementById('category_id').value,
            sub_title: document.getElementById('sub_title').value,
            sub_desc: document.getElementById('sub_desc').value,
        };

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
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error adding sub category',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

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

    function fetchAllData() {
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('categoriesSection').classList.add('hidden');

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

    function fetchSubcategories() {
        $.ajax({
            url: "{{ route('subcategories.fetch') }}",
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(subcategoriesData) {
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('categoriesSection').classList.remove('hidden');

                if (subcategoriesData.success) {
                    window.subcategoriesData = subcategoriesData.subCategories;
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

    function renderCategories() {
        let categoriesGrid = document.getElementById('categoriesGrid');
        categoriesGrid.innerHTML = '';

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




            let colorInfo = colorMap[categories.title] || {
                bg: 'bg-gray-100',
                text: 'text-gray-600',
                icon: 'fas fa-tag'
            };



            const subcategoryCount = window.subcategoriesData.filter(sub => sub.categoires_id == categories.id).length;



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


    function editCategory(categoryId) {
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
        showEditCategoryModal(category);
    }

    function editSubcategory(subcategoryId) {
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
        showEditSubcategoryModal(subcategory);
    }

    function showEditCategoryModal(category) {
        if (!document.getElementById('editCategoryModal')) {
            createEditCategoryModal();
        }
        document.getElementById('edit_category_id').value = category.id;
        document.getElementById('edit_title').value = category.title;
        document.getElementById('edit_decs').value = category.decs || '';
        document.getElementById('editCategoryModal').classList.remove('hidden');
    }

    function showEditSubcategoryModal(subcategory) {
        if (!document.getElementById('editSubCategoryModal')) {
            createEditSubcategoryModal();
        }

        populateEditCategoriesDropdown().then(() => {
            document.getElementById('edit_sub_category_id').value = subcategory.id;
            document.getElementById('edit_category_id_select').value = subcategory.categoires_id;
            document.getElementById('edit_sub_title').value = subcategory.sub_title;
            document.getElementById('edit_sub_desc').value = subcategory.desc || '';

            document.getElementById('editSubCategoryModal').classList.remove('hidden');
        });
    }

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

        document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            updateCategory();
        });

        document.getElementById('editCategoryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditCategoryModal();
            }
        });
    }

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

        document.getElementById('editSubCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            updateSubcategory();
        });

        document.getElementById('editSubCategoryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditSubCategoryModal();
            }
        });
    }

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

    function closeEditCategoryModal() {
        document.getElementById('editCategoryModal').classList.add('hidden');
    }

    function closeEditSubCategoryModal() {
        document.getElementById('editSubCategoryModal').classList.add('hidden');
    }

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
                                fetchAllData();
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