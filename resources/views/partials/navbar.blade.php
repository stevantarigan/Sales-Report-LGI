<!-- Sidebar -->
<nav class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="sidebar-title">SuperAdmin Panel</div>
    </div>

    <div class="sidebar-menu">
        <!-- Dashboard Link untuk SuperAdmin -->
        <a href="{{ route('superadmin.welcome') }}"
            class="menu-item {{ request()->routeIs('superadmin.welcome') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <div class="menu-divider"></div>

        <!-- User Management - Hanya SuperAdmin -->
        <a href="#" class="menu-item" id="userManagementMenu">
            <i class="fas fa-users"></i>
            <span class="menu-text">User Management</span>
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
        </div>

        <!-- CUSTOMERS MANAGEMENT MENU -->
        <a href="#" class="menu-item" id="customerManagementMenu">
            <i class="fas fa-user-friends"></i>
            <span class="menu-text">Customers Management</span>
        </a>

        <div class="submenu" id="customerSubmenu">
            <a href="{{ route('admin.customers.index') }}"
                class="submenu-item {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                All Customers
            </a>
            <a href="{{ route('admin.customers.create') }}"
                class="submenu-item {{ request()->routeIs('admin.customers.create') ? 'active' : '' }}">
                <i class="fas fa-plus"></i>
                Add Customer
            </a>
        </div>

        <!-- PRODUCT MANAGEMENT MENU -->
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
        </div>

        <!-- TRANSACTION MANAGEMENT MENU -->
        <a href="#" class="menu-item" id="transactionManagementMenu">
            <i class="fas fa-exchange-alt"></i>
            <span class="menu-text">Transaction Management</span>
        </a>

        <div class="submenu" id="transactionSubmenu">
            <a href="{{ route('admin.transactions.index') }}"
                class="submenu-item {{ request()->routeIs('admin.transactions.index') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                All Transactions
            </a>
            <a href="{{ route('admin.transactions.create') }}"
                class="submenu-item {{ request()->routeIs('admin.transactions.create') ? 'active' : '' }}">
                <i class="fas fa-plus"></i>
                Add Transaction
            </a>
        </div>

        <div class="menu-divider"></div>

        <!-- Settings Menu -->
        <a href="#" class="menu-item">
            <i class="fas fa-cog"></i>
            <span class="menu-text">Settings</span>
        </a>
    </div>
</nav>
