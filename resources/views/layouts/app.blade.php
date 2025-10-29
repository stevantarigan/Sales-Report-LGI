<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SuperAdmin Dashboard | Sales Management')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
        @include('partials.navbar')

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

        // Sidebar toggle functionality - PERBAIKAN
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

            if (userMenu && userSubmenu) {
                userMenu.addEventListener('click', function(e) {
                    e.preventDefault();
                    userSubmenu.classList.toggle('show');
                    // Close other submenu if open
                    if (productSubmenu && productSubmenu.classList.contains('show')) {
                        productSubmenu.classList.remove('show');
                    }
                });
            }

            if (productMenu && productSubmenu) {
                productMenu.addEventListener('click', function(e) {
                    e.preventDefault();
                    productSubmenu.classList.toggle('show');
                    // Close other submenu if open
                    if (userSubmenu && userSubmenu.classList.contains('show')) {
                        userSubmenu.classList.remove('show');
                    }
                });
            }

            // Typing animation for title
            const typingTitle = document.getElementById('typing-title');
            if (typingTitle && !typingTitle.hasAttribute('data-typed')) {
                const text = typingTitle.textContent;
                typingTitle.textContent = '';
                typingTitle.style.borderRight = '2px solid var(--primary-color)';
                typingTitle.setAttribute('data-typed', 'true');

                let i = 0;
                const typeWriter = () => {
                    if (i < text.length) {
                        typingTitle.textContent += text.charAt(i);
                        i++;
                        setTimeout(typeWriter, 100);
                    } else {
                        // Blinking cursor effect
                        setInterval(() => {
                            typingTitle.style.borderRight = typingTitle.style.borderRight ===
                                '2px solid var(--primary-color)' ?
                                '2px solid transparent' : '2px solid var(--primary-color)';
                        }, 500);
                    }
                };

                // Start typing animation after a short delay
                setTimeout(typeWriter, 500);
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

            // Add ripple effect to buttons
            document.querySelectorAll('.btn-primary').forEach(button => {
                button.addEventListener('click', function(e) {
                    // Remove existing ripples
                    const existingRipples = this.querySelectorAll('span[style*="ripple"]');
                    existingRipples.forEach(ripple => ripple.remove());

                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.6);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    pointer-events: none;
                `;

                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });

        // Global functions
        function createContact() {
            alert('Create Contact functionality would be implemented here');
        }

        function createLead() {
            alert('Create Lead functionality would be implemented here');
        }

        function enableMarketing() {
            alert('Marketing Features functionality would be implemented here');
        }
    </script>

    @stack('scripts')
</body>

</html>
