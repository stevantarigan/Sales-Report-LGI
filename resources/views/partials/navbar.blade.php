<!-- Sidebar -->
<nav class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-crown"></i>
        </div>
        <div class="sidebar-title">SuperAdmin Panel</div>
    </div>

    <div class="sidebar-menu">
        <a href="{{ route('superadmin.welcome') }}"
            class="menu-item {{ request()->routeIs('superadmin.welcome') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <div class="menu-divider"></div>

        <a href="#" class="menu-item" id="userManagementMenu">
            <i class="fas fa-users"></i>
            <span class="menu-text">User Management</span>
            <span class="menu-badge">New</span>
        </a>

        <div class="submenu" id="userSubmenu">
            <a href="{{ route('admin.users.index') }}"
                class="submenu-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                All Users
            </a>
            <a href="{{ route('admin.users.create') }}"
                class="submenu-item {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                <i class="fas fa-plus"></i>
                Add New User
            </a>
            <a href="#" class="submenu-item">
                <i class="fas fa-user-shield"></i>
                User Roles
            </a>
            <a href="#" class="submenu-item">
                <i class="fas fa-chart-bar"></i>
                User Analytics
            </a>
        </div>

        <a href="#" class="menu-item" id="productManagementMenu">
            <i class="fas fa-box"></i>
            <span class="menu-text">Product Management</span>
        </a>

        <div class="submenu" id="productSubmenu">
            <a href="{{ route('products.index') }}"
                class="submenu-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                All Products
            </a>
            <a href="{{ route('products.create') }}"
                class="submenu-item {{ request()->routeIs('products.create') ? 'active' : '' }}">
                <i class="fas fa-plus"></i>
                Add New Product
            </a>
            <a href="#" class="submenu-item">
                <i class="fas fa-tags"></i>
                Categories
            </a>
            <a href="#" class="submenu-item">
                <i class="fas fa-chart-bar"></i>
                Product Analytics
            </a>
        </div>

        <div class="menu-divider"></div>

        <a href="#" class="menu-item">
            <i class="fas fa-cog"></i>
            <span class="menu-text">Settings</span>
        </a>
    </div>
</nav>
