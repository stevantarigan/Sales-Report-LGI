<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard | Sales Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0176d3;
            --primary-dark: #032d60;
            --primary-light: #eaf5fe;
            --secondary-green: #2e844a;
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
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
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
            color: var(--primary-blue);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Performance Metrics */
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
            color: var(--secondary-green);
        }

        .trend-down {
            background: #fde7e9;
            color: var(--danger);
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
            background: var(--primary-blue);
            border-radius: 4px;
            transition: width 0.3s ease;
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
            border-color: var(--primary-blue);
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
            color: var(--primary-blue);
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

        /* My Performance */
        .performance-section {
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
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* Recent Deals */
        .recent-deals {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid var(--border-light);
            animation: fadeIn 0.8s ease-out;
        }

        .deals-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .deal-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .deal-item:hover {
            background: var(--bg-light);
        }

        .deal-icon {
            width: 32px;
            height: 32px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            font-size: 0.875rem;
        }

        .deal-content {
            flex: 1;
        }

        .deal-title {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .deal-info {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .deal-amount {
            text-align: right;
        }

        .deal-value {
            font-weight: 700;
            color: var(--primary-blue);
            font-size: 1.1rem;
        }

        .deal-stage {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        /* Upcoming Tasks */
        .upcoming-tasks {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid var(--border-light);
            animation: slideInRight 0.6s ease-out;
        }

        .tasks-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .task-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .task-item:hover {
            background: var(--bg-light);
        }

        .task-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid var(--border-light);
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .task-checkbox.checked {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .task-checkbox.checked::after {
            content: '✓';
            color: white;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .task-content {
            flex: 1;
        }

        .task-title {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .task-time {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .task-priority {
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 500;
        }

        .priority-high {
            background: #fde7e9;
            color: var(--danger);
        }

        .priority-medium {
            background: #fef4e7;
            color: var(--warning);
        }

        .priority-low {
            background: #e7f6e9;
            color: var(--secondary-green);
        }

        /* Leaderboard */
        .leaderboard {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid var(--border-light);
            animation: slideInRight 0.6s ease-out;
        }

        .leader-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .leader-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .leader-item:hover {
            background: var(--bg-light);
        }

        .leader-rank {
            width: 32px;
            height: 32px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 0.875rem;
        }

        .leader-rank.top-3 {
            background: var(--warning);
            color: white;
        }

        .leader-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .leader-info {
            flex: 1;
        }

        .leader-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .leader-role {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .leader-stats {
            text-align: right;
        }

        .leader-value {
            font-weight: 700;
            color: var(--primary-blue);
            font-size: 1.1rem;
        }

        .leader-label {
            font-size: 0.75rem;
            color: var(--text-light);
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
        .metric-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .metric-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .metric-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .metric-card:nth-child(4) {
            animation-delay: 0.4s;
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
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="brand-text">
                        <h1>Sales Management</h1>
                        <span>Sales Professional Console</span>
                    </div>
                </div>

                <div class="user-nav">
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 0.9rem;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 0.75rem; opacity: 0.8;">Sales Professional</div>
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
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="welcome-text">
                        <h2>Welcome back, {{ Auth::user()->name }}! 👋</h2>
                        <p>Focus on your sales targets and close more deals today</p>
                        <div class="role-badge">
                            <i class="fas fa-chart-line"></i>
                            Sales Professional
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Performance Metrics -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--primary-blue);">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Monthly Target</div>
                            <div class="metric-value">78%</div>
                        </div>
                        <div class="metric-trend trend-up">
                            +12%
                        </div>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: 78%;"></div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--secondary-green);">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Deals Closed</div>
                            <div class="metric-value">24</div>
                        </div>
                        <div class="metric-trend trend-up">
                            +5
                        </div>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: 80%; background: var(--secondary-green);"></div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--warning);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Revenue Generated</div>
                            <div class="metric-value">₿ 42.5K</div>
                        </div>
                        <div class="metric-trend trend-up">
                            +18.7%
                        </div>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: 85%; background: var(--warning);"></div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--danger);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Pending Follow-ups</div>
                            <div class="metric-value">8</div>
                        </div>
                        <div class="metric-trend trend-down">
                            -3
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance & Quick Actions -->
            <div class="row">
                <div class="col-md-8">
                    <div class="performance-section">
                        <div class="section-title">
                            <i class="fas fa-trophy"></i>
                            My Performance
                        </div>

                        <div class="performance-stats">
                            <div class="stat-card">
                                <div class="stat-value">142</div>
                                <div class="stat-label">Total Leads</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">87%</div>
                                <div class="stat-label">Conversion Rate</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">₿ 42.5K</div>
                                <div class="stat-label">Total Revenue</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">18</div>
                                <div class="stat-label">New Opportunities</div>
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
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                    <div class="action-text">
                                        <h6>New Lead</h6>
                                        <span>Add new prospect</span>
                                    </div>
                                </div>
                                <div class="action-item">
                                    <div class="action-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="action-text">
                                        <h6>Log Call</h6>
                                        <span>Record customer call</span>
                                    </div>
                                </div>
                                <div class="action-item">
                                    <div class="action-icon">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="action-text">
                                        <h6>Schedule Meeting</h6>
                                        <span>Book appointment</span>
                                    </div>
                                </div>
                                <div class="action-item">
                                    <div class="action-icon">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <div class="action-text">
                                        <h6>Create Quote</h6>
                                        <span>Prepare proposal</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Upcoming Tasks -->
                    <div class="upcoming-tasks">
                        <div class="section-title">
                            <i class="fas fa-tasks"></i>
                            Today's Tasks
                        </div>
                        <div class="tasks-list">
                            <div class="task-item">
                                <div class="task-checkbox"></div>
                                <div class="task-content">
                                    <div class="task-title">Follow up with ABC Corp</div>
                                    <div class="task-time">10:00 AM</div>
                                </div>
                                <div class="task-priority priority-high">High</div>
                            </div>
                            <div class="task-item">
                                <div class="task-checkbox"></div>
                                <div class="task-content">
                                    <div class="task-title">Prepare Q3 presentation</div>
                                    <div class="task-time">11:30 AM</div>
                                </div>
                                <div class="task-priority priority-medium">Medium</div>
                            </div>
                            <div class="task-item">
                                <div class="task-checkbox"></div>
                                <div class="task-content">
                                    <div class="task-title">Send proposal to XYZ Ltd</div>
                                    <div class="task-time">2:00 PM</div>
                                </div>
                                <div class="task-priority priority-high">High</div>
                            </div>
                            <div class="task-item">
                                <div class="task-checkbox"></div>
                                <div class="task-content">
                                    <div class="task-title">Weekly team meeting</div>
                                    <div class="task-time">3:30 PM</div>
                                </div>
                                <div class="task-priority priority-low">Low</div>
                            </div>
                        </div>
                    </div>

                    <!-- Leaderboard -->
                    <div class="leaderboard">
                        <div class="section-title">
                            <i class="fas fa-medal"></i>
                            Team Leaderboard
                        </div>
                        <div class="leader-list">
                            <div class="leader-item">
                                <div class="leader-rank top-3">1</div>
                                <div class="leader-avatar">JD</div>
                                <div class="leader-info">
                                    <div class="leader-name">John Doe</div>
                                    <div class="leader-role">Senior Sales</div>
                                </div>
                                <div class="leader-stats">
                                    <div class="leader-value">₿ 48K</div>
                                    <div class="leader-label">This Month</div>
                                </div>
                            </div>
                            <div class="leader-item">
                                <div class="leader-rank top-3">2</div>
                                <div class="leader-avatar">SJ</div>
                                <div class="leader-info">
                                    <div class="leader-name">Sarah Johnson</div>
                                    <div class="leader-role">Account Executive</div>
                                </div>
                                <div class="leader-stats">
                                    <div class="leader-value">₿ 42.5K</div>
                                    <div class="leader-label">This Month</div>
                                </div>
                            </div>
                            <div class="leader-item">
                                <div class="leader-rank top-3">3</div>
                                <div class="leader-avatar">MW</div>
                                <div class="leader-info">
                                    <div class="leader-name">Mike Wilson</div>
                                    <div class="leader-role">Sales Manager</div>
                                </div>
                                <div class="leader-stats">
                                    <div class="leader-value">₿ 38K</div>
                                    <div class="leader-label">This Month</div>
                                </div>
                            </div>
                            <div class="leader-item">
                                <div class="leader-rank">4</div>
                                <div class="leader-avatar">EC</div>
                                <div class="leader-info">
                                    <div class="leader-name">Emily Chen</div>
                                    <div class="leader-role">Business Dev</div>
                                </div>
                                <div class="leader-stats">
                                    <div class="leader-value">₿ 35K</div>
                                    <div class="leader-label">This Month</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Deals & Additional Tools -->
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="recent-deals">
                        <div class="section-title">
                            <i class="fas fa-briefcase"></i>
                            Recent Deals
                        </div>
                        <div class="deals-list">
                            <div class="deal-item">
                                <div class="deal-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="deal-content">
                                    <div class="deal-title">Enterprise Software License</div>
                                    <div class="deal-info">ABC Corporation • Closed yesterday</div>
                                </div>
                                <div class="deal-amount">
                                    <div class="deal-value">₿ 15,000</div>
                                    <div class="deal-stage">Closed Won</div>
                                </div>
                            </div>
                            <div class="deal-item">
                                <div class="deal-icon">
                                    <i class="fas fa-play"></i>
                                </div>
                                <div class="deal-content">
                                    <div class="deal-title">Cloud Services Package</div>
                                    <div class="deal-info">XYZ Tech • In negotiation</div>
                                </div>
                                <div class="deal-amount">
                                    <div class="deal-value">₿ 8,500</div>
                                    <div class="deal-stage">Proposal Sent</div>
                                </div>
                            </div>
                            <div class="deal-item">
                                <div class="deal-icon">
                                    <i class="fas fa-play"></i>
                                </div>
                                <div class="deal-content">
                                    <div class="deal-title">Consulting Services</div>
                                    <div class="deal-info">Global Solutions • Meeting scheduled</div>
                                </div>
                                <div class="deal-amount">
                                    <div class="deal-value">₿ 12,000</div>
                                    <div class="deal-stage">Qualified</div>
                                </div>
                            </div>
                            <div class="deal-item">
                                <div class="deal-icon">
                                    <i class="fas fa-pause"></i>
                                </div>
                                <div class="deal-content">
                                    <div class="deal-title">Hardware Equipment</div>
                                    <div class="deal-info">Manufacturing Inc • On hold</div>
                                </div>
                                <div class="deal-amount">
                                    <div class="deal-value">₿ 25,000</div>
                                    <div class="deal-stage">Needs Analysis</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="quick-actions">
                        <div class="section-title">
                            <i class="fas fa-tools"></i>
                            Sales Tools
                        </div>
                        <div class="actions-grid">
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <div class="action-text">
                                    <h6>Commission Calc</h6>
                                    <span>Calculate earnings</span>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <div class="action-text">
                                    <h6>Performance</h6>
                                    <span>View analytics</span>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-file-contract"></i>
                                </div>
                                <div class="action-text">
                                    <h6>Contracts</h6>
                                    <span>Manage agreements</span>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="action-text">
                                    <h6>Training</h6>
                                    <span>Sales resources</span>
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
            document.querySelectorAll('.metric-card, .action-item, .deal-item, .task-item, .leader-item').forEach(
                element => {
                    element.style.animationPlayState = 'paused';
                    observer.observe(element);
                });

            // Task completion functionality
            document.querySelectorAll('.task-checkbox').forEach(checkbox => {
                checkbox.addEventListener('click', function() {
                    this.classList.toggle('checked');

                    // Add completion effect
                    if (this.classList.contains('checked')) {
                        this.parentElement.style.opacity = '0.6';
                    } else {
                        this.parentElement.style.opacity = '1';
                    }
                });
            });

            // Action item click effects
            document.querySelectorAll('.action-item').forEach(item => {
                item.addEventListener('click', function() {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });
    </script>
</body>

</html>
