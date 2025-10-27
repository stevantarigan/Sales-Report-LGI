<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin Dashboard | Sales Management</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6610f2;
            --accent-color: #6f42c1;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --success-color: #28a745;
            --error-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --card-bg: rgba(255, 255, 255, 0.95);
            --card-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(-45deg, #f5f7fa, #e4e8f0, #f0f2f5, #e8ecf1);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23007bff" fill-opacity="0.03" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,192C1248,192,1344,128,1392,96L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            z-index: -1;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(0, 123, 255, 0.05);
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 100px;
            height: 100px;
            top: 70%;
            left: 85%;
            animation-delay: 1s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 40%;
            left: 90%;
            animation-delay: 2s;
        }

        .shape:nth-child(4) {
            width: 120px;
            height: 120px;
            top: 80%;
            left: 10%;
            animation-delay: 3s;
        }

        /* Header Styles */
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.2rem 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.05" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,192C1248,192,1344,128,1392,96L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .logo-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            animation: pulse 2s infinite;
        }

        .logo-icon i {
            font-size: 1.5rem;
        }

        .brand-text h1 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .brand-text span {
            font-size: 0.9rem;
            opacity: 0.9;
            font-weight: 400;
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 16px;
            border-radius: 24px;
            backdrop-filter: blur(10px);
            transition: var(--transition);
        }

        .user-info:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            transition: var(--transition);
            font-weight: 500;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Main Dashboard Content */
        .dashboard-container {
            padding: 2.5rem 0;
        }

        /* Welcome Section */
        .welcome-section {
            margin-bottom: 2.5rem;
        }

        .welcome-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .welcome-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .welcome-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: #6c757d;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        .role-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.8rem;
            margin-bottom: 2.5rem;
        }

        .feature-card {
            background: var(--card-bg);
            border-radius: 18px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
            transition: var(--transition);
        }

        .feature-card:hover .card-icon {
            transform: rotate(10deg) scale(1.1);
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.8rem;
        }

        .card-description {
            font-size: 0.95rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .card-action {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .feature-card:hover .card-action {
            transform: translateX(5px);
            color: var(--secondary-color);
        }

        /* View All Cards Section */
        .view-all-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .view-all-btn {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .view-all-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 123, 255, 0.2);
        }

        .view-all-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .view-all-btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        /* Leads & Opportunities Section */
        .data-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.8rem;
            margin-bottom: 2.5rem;
        }

        .data-card {
            background: var(--card-bg);
            border-radius: 18px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .data-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .data-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .data-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .data-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 6px 15px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .data-list {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .data-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 1rem;
            border-radius: 12px;
            transition: var(--transition);
            cursor: pointer;
        }

        .data-item:hover {
            background: rgba(0, 123, 255, 0.05);
            transform: translateX(5px);
        }

        .data-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        .data-content {
            flex: 1;
        }

        .data-name {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 4px;
        }

        .data-info {
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }

            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1.5rem 0;
            }

            .welcome-card,
            .feature-card,
            .data-card {
                padding: 1.5rem;
            }

            .cards-grid,
            .data-section {
                grid-template-columns: 1fr;
            }

            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .user-nav {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Floating background shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Dashboard Header -->
    <header class="dashboard-header">
        <div class="container">
            <div class="header-content">
                <div class="logo-brand">
                    <div class="logo-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="brand-text">
                        <h1>Sales Management</h1>
                        <span>SuperAdmin Console</span>
                    </div>
                </div>

                <div class="user-nav">
                    <div class="user-info">
                        <div class="user-avatar">
                            S
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 0.95rem;">STEVAN</div>
                            <div style="font-size: 0.75rem; opacity: 0.9;">Super Administrator</div>
                        </div>
                    </div>
                    <form action="#" method="POST">
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Dashboard Content -->
    <main class="dashboard-container">
        <div class="container">
            <!-- Welcome Section -->
            <div class="welcome-section" data-aos="fade-up" data-aos-duration="800">
                <div class="welcome-card">
                    <h1 class="welcome-title">Home</h1>
                    <p class="welcome-subtitle">Welcome, STEVAN</p>
                    <p class="welcome-subtitle">Check out these suggestions to kick off your day.</p>
                    <div class="role-badge">
                        <i class="fas fa-shield-alt"></i>
                        Super Administrator Access
                    </div>
                </div>
            </div>

            <!-- Feature Cards -->
            <div class="cards-grid">
                <div class="feature-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100"
                    onclick="createContact()">
                    <div class="card-icon">
                        <i class="fas fa-address-book"></i>
                    </div>
                    <h3 class="card-title">Create your first contact</h3>
                    <p class="card-description">Growing your sales starts with contacts. Let's walk through it.</p>
                    <div class="card-action">
                        <span>Get Started</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

                <div class="feature-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"
                    onclick="createLead()">
                    <div class="card-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 class="card-title">Create your first lead</h3>
                    <p class="card-description">Let us show you how easy it is to convert your leads into contacts,
                        accounts, and opportunities.</p>
                    <div class="card-action">
                        <span>Get Started</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

                <div class="feature-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300"
                    onclick="enableMarketing()">
                    <div class="card-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3 class="card-title">Turn on marketing features</h3>
                    <p class="card-description">Access powerful tools to reach new audiences and engage customers.</p>
                    <div class="card-action">
                        <span>Get Started</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <!-- View All Cards Section -->
            <div class="view-all-section" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                <button class="view-all-btn">
                    <i class="fas fa-th-large me-2"></i>View All Cards
                </button>
            </div>

            <!-- Leads & Opportunities Section -->
            <div class="data-section">
                <div class="data-card" data-aos="fade-right" data-aos-duration="800" data-aos-delay="100">
                    <div class="data-header">
                        <h3 class="data-title">My Leads</h3>
                        <span class="data-badge">New</span>
                    </div>
                    <div class="data-list">
                        <div class="data-item">
                            <div class="data-avatar">JD</div>
                            <div class="data-content">
                                <div class="data-name">John Doe</div>
                                <div class="data-info">Software Company</div>
                            </div>
                        </div>
                        <div class="data-item">
                            <div class="data-avatar">SJ</div>
                            <div class="data-content">
                                <div class="data-name">Sarah Johnson</div>
                                <div class="data-info">Marketing Agency</div>
                            </div>
                        </div>
                        <div class="data-item">
                            <div class="data-avatar">MB</div>
                            <div class="data-content">
                                <div class="data-name">Michael Brown</div>
                                <div class="data-info">Retail Business</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="data-card" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                    <div class="data-header">
                        <h3 class="data-title">My Opportunities</h3>
                        <span class="data-badge">New</span>
                    </div>
                    <div class="data-list">
                        <div class="data-item">
                            <div class="data-avatar">TC</div>
                            <div class="data-content">
                                <div class="data-name">TechCorp Deal</div>
                                <div class="data-info">$25,000 • Closing in 2 weeks</div>
                            </div>
                        </div>
                        <div class="data-item">
                            <div class="data-avatar">GS</div>
                            <div class="data-content">
                                <div class="data-name">Global Solutions</div>
                                <div class="data-info">$15,000 • In negotiation</div>
                            </div>
                        </div>
                        <div class="data-item">
                            <div class="data-avatar">IS</div>
                            <div class="data-content">
                                <div class="data-name">Innovate Systems</div>
                                <div class="data-info">$50,000 • Discovery phase</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS animations
        AOS.init({
            once: true,
            duration: 800,
            offset: 100
        });

        // Function to handle creating contacts
        function createContact() {
            // Add click animation
            const card = event.currentTarget;
            card.style.transform = 'scale(0.95)';
            setTimeout(() => {
                card.style.transform = '';
            }, 300);

            alert('Create Contact functionality would be implemented here');
            // In a real application, this would open a modal or redirect to a contact creation page
        }

        // Function to handle creating leads
        function createLead() {
            // Add click animation
            const card = event.currentTarget;
            card.style.transform = 'scale(0.95)';
            setTimeout(() => {
                card.style.transform = '';
            }, 300);

            alert('Create Lead functionality would be implemented here');
            // In a real application, this would open a modal or redirect to a lead creation page
        }

        // Function to enable marketing features
        function enableMarketing() {
            // Add click animation
            const card = event.currentTarget;
            card.style.transform = 'scale(0.95)';
            setTimeout(() => {
                card.style.transform = '';
            }, 300);

            alert('Marketing Features functionality would be implemented here');
            // In a real application, this would open a settings modal or redirect to marketing features page
        }

        // Add hover effect to data items
        document.querySelectorAll('.data-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(8px)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });

        // Add ripple effect to buttons
        document.querySelectorAll('.view-all-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const x = e.clientX - e.target.getBoundingClientRect().left;
                const y = e.clientY - e.target.getBoundingClientRect().top;

                const ripple = document.createElement('span');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                ripple.classList.add('ripple-effect');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
</body>

</html>
