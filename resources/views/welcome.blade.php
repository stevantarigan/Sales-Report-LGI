<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin Dashboard | Sales Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0176d3;
            --primary-dark: #032d60;
            --primary-light: #eaf5fe;
            --success: #2e844a;
            --warning: #fe9339;
            --danger: #ea001e;
            --text-dark: #181818;
            --text-light: #706e6b;
            --bg-light: #f3f3f3;
            --border-light: #dddbda;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* Salesforce-inspired Header */
        .salesforce-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-text h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .brand-text span {
            font-size: 0.875rem;
            opacity: 0.9;
            font-weight: 400;
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 16px;
            border-radius: 24px;
            backdrop-filter: blur(10px);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.9rem;
        }

        /* Main Dashboard Layout */
        .dashboard-container {
            padding: 2rem 0;
        }

        /* Welcome Section */
        .welcome-section {
            margin-bottom: 2rem;
        }

        .welcome-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-light);
        }

        .welcome-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-color: var(--primary-blue);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            background: var(--primary-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .card-description {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .card-action {
            color: var(--primary-blue);
            font-weight: 500;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Leads & Opportunities Section */
        .data-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .data-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--border-light);
        }

        .data-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .data-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .data-badge {
            background: var(--primary-light);
            color: var(--primary-blue);
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .data-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .data-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .data-item:hover {
            background: var(--bg-light);
        }

        .data-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .data-content {
            flex: 1;
        }

        .data-name {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .data-info {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        /* View All Cards Section */
        .view-all-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .view-all-btn {
            background: transparent;
            color: var(--primary-blue);
            border: 1px solid var(--primary-blue);
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .view-all-btn:hover {
            background: var(--primary-blue);
            color: white;
        }

        /* Animations */
        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(15px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Stagger animations */
        .feature-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .feature-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .feature-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .btn-salesforce {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-salesforce:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .logout-btn {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body>
    <!-- Salesforce-style Header -->
    <header class="salesforce-header">
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
                            <div style="font-weight: 600; font-size: 0.9rem;">STEVAN</div>
                            <div style="font-size: 0.75rem; opacity: 0.8;">Super Administrator</div>
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
            <div class="welcome-section">
                <div class="welcome-card">
                    <h1 class="welcome-title">Home</h1>
                    <p class="welcome-subtitle">Welcome, STEVAN</p>
                    <p class="welcome-subtitle">Check out these suggestions to kick off your day.</p>
                </div>
            </div>

            <!-- Feature Cards -->
            <div class="cards-grid">
                <div class="feature-card" onclick="createContact()">
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

                <div class="feature-card" onclick="createLead()">
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

                <div class="feature-card" onclick="enableMarketing()">
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
            <div class="view-all-section">
                <button class="view-all-btn">
                    <i class="fas fa-th-large me-2"></i>View All Cards
                </button>
            </div>

            <!-- Leads & Opportunities Section -->
            <div class="data-section">
                <div class="data-card">
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

                <div class="data-card">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to handle creating contacts
        function createContact() {
            alert('Create Contact functionality would be implemented here');
            // In a real application, this would open a modal or redirect to a contact creation page
        }

        // Function to handle creating leads
        function createLead() {
            alert('Create Lead functionality would be implemented here');
            // In a real application, this would open a modal or redirect to a lead creation page
        }

        // Function to enable marketing features
        function enableMarketing() {
            alert('Marketing Features functionality would be implemented here');
            // In a real application, this would open a settings modal or redirect to marketing features page
        }

        // Add interactive animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);

            // Observe all animated elements
            document.querySelectorAll('.feature-card, .data-card').forEach(element => {
                element.style.animationPlayState = 'paused';
                observer.observe(element);
            });
        });
    </script>
</body>

</html>
