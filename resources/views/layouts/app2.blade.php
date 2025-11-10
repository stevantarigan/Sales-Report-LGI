<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AdminSales Dashboard | Sales Management')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <!-- Animated Background -->
    <div class="animated-bg">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
    </div>

    <div class="app-container">
        @include('partials.navbar2')

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            @include('layouts.header')

            <!-- Content Area -->
            <main class="content-area">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('modals')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Sidebar toggle event
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');

                    // Change icon based on state
                    const icon = sidebarToggle.querySelector('i');
                    if (sidebar.classList.contains('collapsed')) {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    } else {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    }
                });
            }

            // Menu toggle functionality
            const userMenu = document.getElementById('userManagementMenu');
            const userSubmenu = document.getElementById('userSubmenu');
            const productMenu = document.getElementById('productManagementMenu');
            const productSubmenu = document.getElementById('productSubmenu');
            const transactionMenu = document.getElementById('transactionManagementMenu');
            const transactionSubmenu = document.getElementById('transactionSubmenu');

            // User Management Menu
            if (userMenu && userSubmenu) {
                userMenu.addEventListener('click', function(e) {
                    e.preventDefault();
                    userSubmenu.classList.toggle('show');
                    // Close other submenus if open
                    closeOtherSubmenus(userSubmenu);
                });
            }

            // Product Management Menu
            if (productMenu && productSubmenu) {
                productMenu.addEventListener('click', function(e) {
                    e.preventDefault();
                    productSubmenu.classList.toggle('show');
                    // Close other submenus if open
                    closeOtherSubmenus(productSubmenu);
                });
            }

            // Transaction Management Menu
            if (transactionMenu && transactionSubmenu) {
                transactionMenu.addEventListener('click', function(e) {
                    e.preventDefault();
                    transactionSubmenu.classList.toggle('show');
                    // Close other submenus if open
                    closeOtherSubmenus(transactionSubmenu);
                });
            }
            // Customer Management Menu Toggle
            const customerManagementMenu = document.getElementById('customerManagementMenu');
            const customerSubmenu = document.getElementById('customerSubmenu');

            if (customerManagementMenu && customerSubmenu) {
                customerManagementMenu.addEventListener('click', function(e) {
                    e.preventDefault();
                    customerSubmenu.classList.toggle('show');

                    // Rotate icon
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-rotate-90');
                });

                // Keep submenu open if current page is active
                const activeCustomerLink = customerSubmenu.querySelector('.submenu-item.active');
                if (activeCustomerLink) {
                    customerSubmenu.classList.add('show');
                    const icon = customerManagementMenu.querySelector('i');
                    icon.classList.add('fa-rotate-90');
                }
            }
            // Function to close other submenus
            function closeOtherSubmenus(currentSubmenu) {
                const allSubmenus = [userSubmenu, productSubmenu, transactionSubmenu];
                allSubmenus.forEach(submenu => {
                    if (submenu && submenu !== currentSubmenu && submenu.classList.contains('show')) {
                        submenu.classList.remove('show');
                    }
                });
            }

            // Handle window resize for responsive behavior
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    if (sidebar) sidebar.classList.add('collapsed');
                    if (mainContent) mainContent.classList.remove('expanded');
                    if (sidebarToggle) {
                        const icon = sidebarToggle.querySelector('i');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                } else {
                    if (sidebar) sidebar.classList.remove('collapsed');
                    if (mainContent) mainContent.classList.add('expanded');
                    if (sidebarToggle) {
                        const icon = sidebarToggle.querySelector('i');
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    }
                }
            });

            // Initialize responsive state
            if (window.innerWidth <= 768) {
                if (sidebar) sidebar.classList.add('collapsed');
                if (mainContent) mainContent.classList.remove('expanded');
            } else {
                if (sidebar) sidebar.classList.remove('collapsed');
                if (mainContent) mainContent.classList.add('expanded');
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
