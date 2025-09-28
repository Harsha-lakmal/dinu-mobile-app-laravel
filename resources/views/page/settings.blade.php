<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-4 py-6">
                    <!-- Settings Header -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Settings</h1>
                        <p class="text-gray-600 mt-1">Manage your application preferences and configuration</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column - Settings Navigation -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-lg shadow">
                                <div class="p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900">Settings Menu</h3>
                                </div>
                                <nav class="p-2">
                                    <a href="#" class="flex items-center px-3 py-3 text-gray-700 bg-indigo-50 rounded-md mb-1">
                                        <i class="fas fa-user-cog mr-3 text-indigo-600"></i>
                                        <span>General Settings</span>
                                    </a>
                                    <a href="#" class="flex items-center px-3 py-3 text-gray-700 hover:bg-gray-50 rounded-md mb-1">
                                        <i class="fas fa-bell mr-3"></i>
                                        <span>Notifications</span>
                                    </a>
                                    <a href="#" class="flex items-center px-3 py-3 text-gray-700 hover:bg-gray-50 rounded-md mb-1">
                                        <i class="fas fa-shield-alt mr-3"></i>
                                        <span>Security</span>
                                    </a>
                                    <a href="#" class="flex items-center px-3 py-3 text-gray-700 hover:bg-gray-50 rounded-md mb-1">
                                        <i class="fas fa-palette mr-3"></i>
                                        <span>Appearance</span>
                                    </a>
                                    <a href="#" class="flex items-center px-3 py-3 text-gray-700 hover:bg-gray-50 rounded-md mb-1">
                                        <i class="fas fa-database mr-3"></i>
                                        <span>Data Management</span>
                                    </a>
                                    <a href="#" class="flex items-center px-3 py-3 text-gray-700 hover:bg-gray-50 rounded-md">
                                        <i class="fas fa-plug mr-3"></i>
                                        <span>Integrations</span>
                                    </a>
                                </nav>
                            </div>
                        </div>

                        <!-- Right Column - Settings Content -->
                        <div class="lg:col-span-2">
                            <!-- General Settings Card -->
                            <div class="bg-white rounded-lg shadow mb-6">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                        <i class="fas fa-user-cog text-indigo-600 mr-2"></i>
                                        General Settings
                                    </h3>
                                </div>
                                <div class="p-6 space-y-6">
                                    <!-- Company Information -->
                                    <div>
                                        <h4 class="text-md font-medium text-gray-900 mb-4">Company Information</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="My Business Inc.">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                                <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="contact@mybusiness.com">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                                <input type="tel" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="+1 (555) 123-4567">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                                                <input type="url" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="https://mybusiness.com">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Preferences -->
                                    <div>
                                        <h4 class="text-md font-medium text-gray-900 mb-4">Preferences</h4>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <label class="text-sm font-medium text-gray-700">Email Notifications</label>
                                                    <p class="text-sm text-gray-500">Receive email updates about your account</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" class="sr-only peer" checked>
                                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                                </label>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <label class="text-sm font-medium text-gray-700">SMS Notifications</label>
                                                    <p class="text-sm text-gray-500">Receive text message alerts</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" class="sr-only peer">
                                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                                </label>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <label class="text-sm font-medium text-gray-700">Auto-backup Data</label>
                                                    <p class="text-sm text-gray-500">Automatically backup your data daily</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" class="sr-only peer" checked>
                                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Regional Settings -->
                                    <div>
                                        <h4 class="text-md font-medium text-gray-900 mb-4">Regional Settings</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Time Zone</label>
                                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option>Eastern Time (ET)</option>
                                                    <option selected>Central Time (CT)</option>
                                                    <option>Mountain Time (MT)</option>
                                                    <option>Pacific Time (PT)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Date Format</label>
                                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option selected>MM/DD/YYYY</option>
                                                    <option>DD/MM/YYYY</option>
                                                    <option>YYYY-MM-DD</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option selected>USD ($)</option>
                                                    <option>EUR (€)</option>
                                                    <option>GBP (£)</option>
                                                    <option>JPY (¥)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option selected>English</option>
                                                    <option>Spanish</option>
                                                    <option>French</option>
                                                    <option>German</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Save Changes
                                    </button>
                                </div>
                            </div>

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
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                                <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                                <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                                <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Two-Factor Authentication -->
                                    <div>
                                        <h4 class="text-md font-medium text-gray-900 mb-4">Security</h4>
                                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                            <div>
                                                <label class="text-sm font-medium text-gray-700">Two-Factor Authentication</label>
                                                <p class="text-sm text-gray-500">Add an extra layer of security to your account</p>
                                            </div>
                                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                                Enable
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Danger Zone -->
                                    <div class="border border-red-200 rounded-lg bg-red-50">
                                        <div class="p-4">
                                            <h4 class="text-md font-medium text-red-800 mb-2">Danger Zone</h4>
                                            <p class="text-sm text-red-600 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                                            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                                Delete Account
                                            </button>
                                        </div>
                                    </div>
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

        // Toggle switch functionality
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const isChecked = this.checked;
                console.log(`Toggle switched to: ${isChecked}`);
            });
        });
    </script>
</body>
</html>