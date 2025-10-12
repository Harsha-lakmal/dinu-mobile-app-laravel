<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Include jQuery and SweetAlert2 -->
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
        .toggle-bg {
            background-color: #d1d5db;
        }
        .toggle-bg:checked {
            background-color: #4f46e5;
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
                        <h2 class="text-lg font-semibold text-gray-800">Settings</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">John Doe</span>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Logout
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-4xl mx-auto">
                    <!-- Account Settings Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-user-shield text-indigo-600 mr-2"></i>
                                Account Settings
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Password Change -->
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-4">Change Password</h4>
                                <form id="passwordForm" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                        <input type="password" id="currentPassword" name="current_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                        <input type="password" id="newPassword" name="new_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                        <input type="password" id="confirmPassword" name="confirm_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    </div>
                                    <button type="button" id="changePasswordBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Change Password
                                    </button>
                                </form>
                            </div>

                            <!-- Two-Factor Authentication -->
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-4">Security</h4>
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">Two-Factor Authentication</label>
                                        <p class="text-sm text-gray-500">Add an extra layer of security to your account</p>
                                    </div>
                                    <button id="enable2faBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Enable
                                    </button>
                                </div>
                            </div>

                            <!-- Danger Zone -->
                            <div class="border border-red-200 rounded-lg bg-red-50">
                                <div class="p-4">
                                    <h4 class="text-md font-medium text-red-800 mb-2">Danger Zone</h4>
                                    <p class="text-sm text-red-600 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                                    <button id="deleteAccountBtn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Delete Account
                                    </button>
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

        // Password change functionality
        document.getElementById('changePasswordBtn').addEventListener('click', function() {
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Basic validation
            if (!currentPassword || !newPassword || !confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please fill in all password fields.'
                });
                return;
            }
            
            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'New password and confirmation do not match.'
                });
                return;
            }
            
            if (newPassword.length < 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'New password must be at least 8 characters long.'
                });
                return;
            }
            
            // Prepare form data
            const formData = {
                current_password: currentPassword,
                new_password: newPassword,
            };
            
      
           
            changePassword(formData);
        });

        // Two-factor authentication functionality
        document.getElementById('enable2faBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Enable Two-Factor Authentication',
                text: 'Are you sure you want to enable two-factor authentication?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Yes, enable it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Here you would typically make an API call to enable 2FA
                    // For now, we'll just show a success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Two-factor authentication has been enabled.'
                    });
                    
                    // Update button text and style
                    const button = document.getElementById('enable2faBtn');
                    button.textContent = 'Disable';
                    button.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                    button.classList.add('bg-gray-600', 'hover:bg-gray-700');
                    
                    // Update event listener for disable functionality
                    button.removeEventListener('click', arguments.callee);
                    button.addEventListener('click', function() {
                        Swal.fire({
                            title: 'Disable Two-Factor Authentication',
                            text: 'Are you sure you want to disable two-factor authentication?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc2626',
                            cancelButtonColor: '#d1d5db',
                            confirmButtonText: 'Yes, disable it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Here you would typically make an API call to disable 2FA
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Two-factor authentication has been disabled.'
                                });
                                
                                // Reset button
                                button.textContent = 'Enable';
                                button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                                button.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                                
                                // Reset event listener
                                button.removeEventListener('click', arguments.callee);
                                button.addEventListener('click', arguments.callee.caller);
                            }
                        });
                    });
                }
            });
        });

        // Delete account functionality
        document.getElementById('deleteAccountBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Yes, delete it!',
                input: 'password',
                inputPlaceholder: 'Enter your password to confirm',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
                preConfirm: (password) => {
                    if (!password) {
                        Swal.showValidationMessage('Please enter your password');
                    }
                    return password;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Here you would typically make an API call to delete the account
                    // For now, we'll just show a success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Your account has been deleted.',
                        confirmButtonColor: '#4f46e5'
                    });
                }
            });
        });

        // Fixed changePassword function
        function changePassword(formData) {
                 console.log(formData);
            $.ajax({
                url: "{{ route('change.password') }}",
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Password changed successfully!'
                        }).then(() => {
                            // Reset the form
                            document.getElementById('passwordForm').reset();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to change password.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while changing the password.'
                    });
                }
            });
        }
    </script>
</body>
</html>