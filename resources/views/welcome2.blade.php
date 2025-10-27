<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminSales Dashboard | Sales Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #2e844a;
            --primary-dark: #1c3326;
            --primary-light: #e7f6e9;
            --secondary-blue: #0176d3;
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
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-green) 100%);
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
            background: var(--primary-green);
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

        .welcome-banner {
            background: white;
            border-radius: 12px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-light);
            animation: slideDown 0.6s ease-out;
        }

        .welcome-content {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .welcome-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-green), var(--primary-dark));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }

        .welcome-text h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            color: var(--text-light);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .role-badge {
            background: var(--primary-light);
            color: var(--primary-green);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Metrics Grid */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .metric-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease-out;
        }

        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .metric-header {
            display: flex;
            align-items: center;
            justify-content: between;
            margin-bottom: 1rem;
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .metric-info {
            flex: 1;
            margin-left: 1rem;
        }

        .metric-title {
            font-size: 0.875rem;
            color: var(--text-light);
            font-weight: 500;
            margin-bottom: 4px;
        }

        .metric-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .metric-trend {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        .trend-up {
            background: #e7f6e9;
            color: var(--primary-green);
        }

        .trend-down {
            background: #fde7e9;
            color: var(--danger);
        }

        /* Quick Actions */
        .quick-actions {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-light);
            animation: slideUp 0.6s ease-out;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .action-item:hover {
            background: var(--primary-light);
            border-color: var(--primary-green);
            transform: translateX(4px);
        }

        .action-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-green);
            font-size: 1rem;
        }

        .action-text h6 {
            font-weight: 600;
            margin: 0;
            color: var(--text-dark);
        }

        .action-text span {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        /* Team Performance */
        .team-performance {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-light);
            animation: fadeIn 0.8s ease-out;
        }

        .performance-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            text-align: center;
            padding: 1.5rem;
            border-radius: 12px;
            background: var(--bg-light);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* Recent Activity */
        .recent-activity {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid var(--border-light);
            animation: fadeIn 0.8s ease-out;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .activity-item:hover {
            background: var(--bg-light);
        }

        .activity-icon {
            width: 32px;
            height: 32px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-green);
            font-size: 0.875rem;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .activity-time {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        /* Top Performers */
        .top-performers {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid var(--border-light);
            animation: slideInRight 0.6s ease-out;
        }

        .performer-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .performer-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .performer-item:hover {
            background: var(--bg-light);
        }

        .performer-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .performer-info {
            flex: 1;
        }

        .performer-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .performer-role {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .performer-stats {
            text-align: right;
        }

        .performer-value {
            font-weight: 700;
            color: var(--primary-green);
            font-size: 1.1rem;
        }

        .performer-label {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        /* Dashboard Grid Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Progress Bars */
        .progress-bar-custom {
            height: 8px;
            background: var(--border-light);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 8px;
        }

        .progress-fill {
            height: 100%;
            background: var(--primary-green);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        /* Charts and Graphs */
        .chart-container {
            height: 200px;
            display: flex;
            align-items: flex-end;
            gap: 8px;
            margin-top: 1rem;
        }

        .chart-bar {
            flex: 1;
            background: var(--primary-green);
            border-radius: 4px 4px 0 0;
            transition: all 0.3s ease;
            position: relative;
        }

        .chart-bar:hover {
            opacity: 0.8;
            transform: scaleY(1.05);
        }

        .chart-label {
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.75rem;
            color: var(--text-light);
            white-space: nowrap;
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

        @keyframes slideInRight {
            from {
                transform: translateX(30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
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
        .metric-card:nth-child(1) { animation-delay: 0.1s; }
        .metric-card:nth-child(2) { animation-delay: 0.2s; }
        .metric-card:nth-child(3) { animation-delay: 0.3s; }
        .metric-card:nth-child(4) { animation-delay: 0.4s; }

        .btn-salesforce {
            background: var(--primary-green);
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
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="brand-text">
                        <h1>Sales Management</h1>
                        <span>Admin Sales Console</span>
                    </div>
                </div>

                <div class="user-nav">
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 0.9rem;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 0.75rem; opacity: 0.8;">Admin Sales</div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
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
            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <div class="welcome-content">
                    <div class="welcome-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="welcome-text">
                        <h2>Welcome back, {{ Auth::user()->name }}! 👋</h2>
                        <p>Manage your sales team and track performance metrics effectively</p>
                        <div class="role-badge">
                            <i class="fas fa-user-cog"></i>
                            Admin Sales Access
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--primary-green);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Team Performance</div>
                            <div class="metric-value">89%</div>
                        </div>
                        <div class="metric-trend trend-up">
                            +5.2%
                        </div>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: 89%;"></div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--secondary-blue);">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Sales Target</div>
                            <div class="metric-value">124%</div>
                        </div>
                        <div class="metric-trend trend-up">
                            +18.7%
                        </div>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: 100%; background: var(--secondary-blue);"></div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--warning);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Active Team</div>
                            <div class="metric-value">24/28</div>
                        </div>
                        <div class="metric-trend trend-up">
                            +2
                        </div>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: 86%; background: var(--warning);"></div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--danger);">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Pending Approvals</div>
                            <div class="metric-value">7</div>
                        </div>
                        <div class="metric-trend trend-down">
                            -3
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Sales Performance Chart -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-chart-bar"></i>
                            Sales Performance
                        </div>
                    </div>
                    <div class="chart-container">
                        <div class="chart-bar" style="height: 70%;">
                            <div class="chart-label">Mon</div>
                        </div>
                        <div class="chart-bar" style="height: 85%; background: var(--secondary-blue);">
                            <div class="chart-label">Tue</div>
                        </div>
                        <div class="chart-bar" style="height: 60%;">
                            <div class="chart-label">Wed</div>
                        </div>
                        <div class="chart-bar" style="height: 90%; background: var(--secondary-blue);">
                            <div class="chart-label">Thu</div>
                        </div>
                        <div class="chart-bar" style="height: 95%;">
                            <div class="chart-label">Fri</div>
                        </div>
                        <div class="chart-bar" style="height: 75%; background: var(--secondary-blue);">
                            <div class="chart-label">Sat</div>
                        </div>
                        <div class="chart-bar" style="height: 50%;">
                            <div class="chart-label">Sun</div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Overview -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-dollar-sign"></i>
                            Revenue Overview
                        </div>
                    </div>
                    <div class="performance-stats">
                        <div class="stat-card">
                            <div class="stat-value">₿ 248K</div>
                            <div class="stat-label">Total Revenue</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">₿ 142K</div>
                            <div class="stat-label">This Month</div>
                        </div>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: 75%;"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 8px;">
                        <span style="font-size: 0.75rem; color: var(--text-light);">Monthly Target</span>
                        <span style="font-size: 0.75rem; font-weight: 600; color: var(--primary-green);">75%</span>
                    </div>
                </div>

                <!-- Team Distribution -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-users"></i>
                            Team Distribution
                        </div>
                    </div>
                    <div style="margin-top: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="font-size: 0.875rem;">Sales Executives</span>
                            <span style="font-size: 0.875rem; font-weight: 600;">12</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" style="width: 60%;"></div>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin: 1rem 0 8px 0;">
                            <span style="font-size: 0.875rem;">Account Managers</span>
                            <span style="font-size: 0.875rem; font-weight: 600;">8</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" style="width: 40%; background: var(--secondary-blue);"></div>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin: 1rem 0 8px 0;">
                            <span style="font-size: 0.875rem;">Business Dev</span>
                            <span style="font-size: 0.875rem; font-weight: 600;">4</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" style="width: 20%; background: var(--warning);"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Performance & Quick Actions -->
            <div class="row">
                <div class="col-md-8">
                    <div class="team-performance">
                        <div class="section-title">
                            <i class="fas fa-trophy"></i>
                            Team Performance Overview
                        </div>

                        <div class="performance-stats">
                            <div class="stat-card">
                                <div class="stat-value">142</div>
                                <div class="stat-label">Closed Deals</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">87%</div>
                                <div class="stat-label">Success Rate</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">18</div>
                                <div class="stat-label">New Leads</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">5.2</div>
                                <div class="stat-label">Avg. Rating</div>
                            </div>
                        </div>

                        <div class="quick-actions">
                            <div class="section-title">
                                <i class="fas fa-bolt"></i>
                                Quick Actions
                            </div>
                            <div class="actions-grid">
                                <div class="action-item">
                                    <div class="action-icon">
                                        <i class="fas fa-users-cog"></i>
                                    </div>
                                    <div class="action-text">
                                        <h6>Team Management</h6>
                                        <span>Manage sales team members</span>
                                    </div>
                                </div>
                                <div class="action-item">
                                    <div class="action-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div class="action-text">
                                        <h6>Sales Reports</h6>
                                        <span>Generate performance reports</span>
                                    </div>
                                </div>
                                <div class="action-item">
                                    <div class="action-icon">
                                        <i class="fas fa-target"></i>
                                    </div>
                                    <div class="action-text">
                                        <h6>Set Targets</h6>
                                        <span>Define sales targets</span>
                                    </div>
                                </div>
                                <div class="action-item">
                                    <div class="action-icon">
                                        <i class="fas fa-handshake"></i>
                                    </div>
                                    <div class="action-text">
                                        <h6>Deal Approval</h6>
                                        <span>Review pending deals</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Top Performers -->
                    <div class="top-performers">
                        <div class="section-title">
                            <i class="fas fa-medal"></i>
                            Top Performers
                        </div>
                        <div class="performer-list">
                            <div class="performer-item">
                                <div class="performer-avatar">JD</div>
                                <div class="performer-info">
                                    <div class="performer-name">John Doe</div>
                                    <div class="performer-role">Senior Sales</div>
                                </div>
                                <div class="performer-stats">
                                    <div class="performer-value">₿ 42K</div>
                                    <div class="performer-label">This Month</div>
                                </div>
                            </div>
                            <div class="performer-item">
                                <div class="performer-avatar">SJ</div>
                                <div class="performer-info">
                                    <div class="performer-name">Sarah Johnson</div>
                                    <div class="performer-role">Account Executive</div>
                                </div>
                                <div class="performer-stats">
                                    <div class="performer-value">₿ 38K</div>
                                    <div class="performer-label">This Month</div>
                                </div>
                            </div>
                            <div class="performer-item">
                                <div class="performer-avatar">MW</div>
                                <div class="performer-info">
                                    <div class="performer-name">Mike Wilson</div>
                                    <div class="performer-role">Sales Manager</div>
                                </div>
                                <div class="performer-stats">
                                    <div class="performer-value">₿ 35K</div>
                                    <div class="performer-label">This Month</div>
                                </div>
                            </div>
                            <div class="performer-item">
                                <div class="performer-avatar">EC</div>
                                <div class="performer-info">
                                    <div class="performer-name">Emily Chen</div>
                                    <div class="performer-role">Business Dev</div>
                                </div>
                                <div class="performer-stats">
                                    <div class="performer-value">₿ 32K</div>
                                    <div class="performer-label">This Month</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="recent-activity">
                        <div class="section-title">
                            <i class="fas fa-clock"></i>
                            Recent Activity
                        </div>
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">New team member onboarded</div>
                                    <div class="activity-time">30 minutes ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Monthly report generated</div>
                                    <div class="activity-time">2 hours ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-target"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Q4 targets updated</div>
                                    <div class="activity-time">5 hours ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-award"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Team performance bonus approved</div>
                                    <div class="activity-time">Yesterday</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Actions -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="quick-actions">
                        <div class="section-title">
                            <i class="fas fa-cogs"></i>
                            Management Tools
                        </div>
                        <div class="actions-grid">
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <div class="action-text">
                                    <h6>Commission Reports</h6>
                                    <span>Calculate team commissions</span>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="action-text">
                                    <h6>Schedule Planning</h6>
                                    <span>Plan team schedules</span>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="action-text">
                                    <h6>Training Materials</h6>
                                    <span>Access training resources</span>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div class="action-text">
                                    <h6>Team Communication</h6>
                                    <span>Send team announcements</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
            document.querySelectorAll('.metric-card, .action-item, .performer-item, .activity-item, .dashboard-card').forEach(
                element => {
                    element.style.animationPlayState = 'paused';
                    observer.observe(element);
                });

            // Add click handlers for action items
            document.querySelectorAll('.action-item').forEach(item => {
                item.addEventListener('click', function() {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            // Animate chart bars on load
            setTimeout(() => {
                document.querySelectorAll('.chart-bar').forEach((bar, index) => {
                    setTimeout(()