<nav class="mt-6">
    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
        <i class="fas fa-tachometer-alt mr-3"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('stock') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('stock') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
        <i class="fas fa-boxes mr-3"></i>
        <span>Stock</span>
    </a>

    <a href="{{ route('reports') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('reports') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
        <i class="fas fa-chart-bar mr-3"></i>
        <span>Reports</span>
    </a>

    <a href="{{ route('categories') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('categories') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
        <i class="fas fa-tags mr-3"></i>
        <span>Categories</span>
    </a>

    <a href="{{ route('users') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('users') ? 'bg-indigo-50 text-indigo-600 border-r-2 border-indigo-600' : '' }}">
        <i class="fas fa-users mr-3"></i>
        <span>Users</span>
    </a>
</nav>