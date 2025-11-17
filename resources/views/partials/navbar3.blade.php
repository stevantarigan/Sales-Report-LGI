<!-- Sidebar (Sales Panel) -->
<nav class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-handshake"></i>
        </div>
        <div class="sidebar-title">Sales Panel</div>
    </div>

    <div class="sidebar-menu">
        <!-- Dashboard -->
        <a href="{{ route('sales.dashboard') }}"
            class="menu-item {{ request()->routeIs('sales.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <div class="menu-divider"></div>

        <!-- Product Menu -->
        <a href="#" class="menu-item" id="productMenu">
            <i class="fas fa-box"></i>
            <span class="menu-text">Products</span>
        </a>

        <div class="submenu" id="productSubmenu">
            <a href="{{ route('sales.products') }}"
                class="submenu-item {{ request()->routeIs('sales.products') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                All Products
            </a>
            <a href="{{ route('products.create') }}"
                class="submenu-item {{ request()->routeIs('products.create') ? 'active' : '' }}">
                <i class="fas fa-plus"></i>
                Add New Product
            </a>
        </div>

        <!-- Customer Menu -->
        <a href="#" class="menu-item" id="customerMenu">
            <i class="fas fa-user-friends"></i>
            <span class="menu-text">Customers</span>
        </a>

        <div class="submenu" id="customerSubmenu">
            <a href="{{ route('sales.customers') }}"
                class="submenu-item {{ request()->routeIs('sales.customers') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                All Customers
            </a>
            <a href="{{ route('admin.customers.create') }}"
                class="submenu-item {{ request()->routeIs('admin.customers.create') ? 'active' : '' }}">
                <i class="fas fa-plus"></i>
                Add Customer
            </a>
        </div>

        <!-- Transaction Menu -->
        <a href="#" class="menu-item" id="transactionMenu">
            <i class="fas fa-exchange-alt"></i>
            <span class="menu-text">Transactions</span>
        </a>

        <div class="submenu" id="transactionSubmenu">
            <a href="{{ route('sales.transactions') }}"
                class="submenu-item {{ request()->routeIs('sales.transactions') ? 'active' : '' }}">
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

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST" class="menu-item logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span class="menu-text">Logout</span>
            </button>
        </form>
    </div>
</nav>

<!-- Optional JS to toggle submenu -->
<script>
    document.querySelectorAll('.menu-item[id]').forEach(menu => {
        menu.addEventListener('click', () => {
            const submenu = document.getElementById(menu.id.replace('Menu', 'Submenu'));
            submenu?.classList.toggle('show');
        });
    });
</script>
