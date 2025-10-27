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

        /* Metrics Grid */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .metric-card {
            background: var(--card-bg);
            border-radius: 18px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .metric-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .metric-icon {
            width: 50px;
            height: 50px;
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
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .metric-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        .metric-trend {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        .trend-up {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .trend-down {
            background: rgba(220, 53, 69, 0.1);
            color: var(--error-color);
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

        /* User Management Section */
        .user-management {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            margin-bottom: 2.5rem;
            transition: var(--transition);
        }

        .user-management:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .user-management::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary-color);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .search-box {
            position: relative;
            min-width: 300px;
        }

        .search-box input {
            padding-left: 2.5rem;
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: var(--transition);
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .btn-add-user {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            transition: var(--transition);
            padding: 10px 20px;
        }

        .btn-add-user:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 7px 15px rgba(103, 16, 242, 0.3);
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }

        .users-table th {
            background: rgba(0, 123, 255, 0.05);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--dark-color);
            border-bottom: 2px solid rgba(0, 123, 255, 0.1);
        }

        .users-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            vertical-align: middle;
        }

        .users-table tr {
            transition: var(--transition);
        }

        .users-table tr:hover {
            background: rgba(0, 123, 255, 0.03);
            transform: translateX(5px);
        }

        .user-avatar-table {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 10px;
        }

        .user-info-table {
            display: flex;
            align-items: center;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .status-inactive {
            background: rgba(220, 53, 69, 0.1);
            color: var(--error-color);
        }

        .role-badge-table {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .role-superadmin {
            background: rgba(0, 123, 255, 0.1);
            color: var(--primary-color);
        }

        .role-adminsales {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .role-sales {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-edit {
            background: rgba(0, 123, 255, 0.1);
            color: var(--primary-color);
        }

        .btn-edit:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }

        .btn-deactivate {
            background: rgba(220, 53, 69, 0.1);
            color: var(--error-color);
        }

        .btn-deactivate:hover {
            background: var(--error-color);
            color: white;
            transform: scale(1.1);
        }

        .btn-reset {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }

        .btn-reset:hover {
            background: var(--warning-color);
            color: white;
            transform: scale(1.1);
        }

        .btn-delete {
            background: rgba(220, 53, 69, 0.1);
            color: var(--error-color);
        }

        .btn-delete:hover {
            background: var(--error-color);
            color: white;
            transform: scale(1.1);
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .pagination-info {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-bottom: none;
            padding: 1.5rem;
            border-radius: 20px 20px 0 0;
        }

        .modal-title {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
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
            .data-card,
            .user-management {
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

            .table-header {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                min-width: 100%;
            }

            .users-table {
                font-size: 0.85rem;
            }

            .action-buttons {
                flex-wrap: wrap;
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
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 0.95rem;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 0.75rem; opacity: 0.9;">Super Administrator</div>
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
            <!-- Welcome Section -->
            <div class="welcome-section" data-aos="fade-up" data-aos-duration="800">
                <div class="welcome-card">
                    <h1 class="welcome-title">Home</h1>
                    <p class="welcome-subtitle">Welcome, {{ Auth::user()->name }}</p>
                    <p class="welcome-subtitle">Check out these suggestions to kick off your day.</p>
                    <div class="role-badge">
                        <i class="fas fa-shield-alt"></i>
                        Super Administrator Access
                    </div>
                </div>
            </div>

            <!-- Metrics Grid -->
            <div class="metrics-grid">
                <div class="metric-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--primary-color);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Total Users</div>
                            <div class="metric-value">{{ $totalUsers }}</div>
                        </div>
                        <div class="metric-trend trend-up">
                            +{{ $userGrowth }}%
                        </div>
                    </div>
                </div>

                <div class="metric-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--success-color);">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Active Users</div>
                            <div class="metric-value">{{ $activeUsers }}</div>
                        </div>
                        <div class="metric-trend trend-up">
                            +{{ $activeGrowth }}%
                        </div>
                    </div>
                </div>

                <div class="metric-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--warning-color);">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">New This Month</div>
                            <div class="metric-value">{{ $newUsersThisMonth }}</div>
                        </div>
                        <div class="metric-trend trend-up">
                            +{{ $monthlyGrowth }}%
                        </div>
                    </div>
                </div>

                <div class="metric-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <div class="metric-header">
                        <div class="metric-icon" style="background: var(--info-color);">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Admin Users</div>
                            <div class="metric-value">{{ $adminUsers }}</div>
                        </div>
                        <div class="metric-trend trend-up">
                            +{{ $adminGrowth }}
                        </div>
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

            <!-- User Management Section -->
            <div class="user-management" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                <div class="section-title">
                    <i class="fas fa-users-cog"></i>
                    User Management
                </div>

                <div class="table-header">
                    <h5 class="mb-0 fw-semibold">All System Users ({{ $users->total() }})</h5>
                    <div class="d-flex gap-3">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" id="searchInput"
                                placeholder="Search users..." value="{{ request('search') }}">
                        </div>
                        <button class="btn btn-add-user" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="fas fa-plus me-2"></i>Add User
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>USR{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        <div class="user-info-table">
                                            <div class="user-avatar-table"
                                                style="background: {{ $user->role === 'superadmin' ? 'var(--primary-color)' : ($user->role === 'adminsales' ? 'var(--success-color)' : 'var(--warning-color)') }};">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->role === 'superadmin')
                                            <span class="role-badge-table role-superadmin">SuperAdmin</span>
                                        @elseif($user->role === 'adminsales')
                                            <span class="role-badge-table role-adminsales">AdminSales</span>
                                        @else
                                            <span class="role-badge-table role-sales">Sales</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->is_active)
                                            <span class="status-badge status-active">Active</span>
                                        @else
                                            <span class="status-badge status-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->last_login_at)
                                            {{ $user->last_login_at->format('M j, Y H:i') }}
                                        @else
                                            <span class="text-muted">Never</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->created_at->format('M j, Y') }}
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon btn-edit" title="Edit User"
                                                onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->phone }}', {{ $user->is_active ? 'true' : 'false' }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-reset" title="Reset Password"
                                                onclick="resetPassword({{ $user->id }})">
                                                <i class="fas fa-key"></i>
                                            </button>
                                            @if ($user->is_active)
                                                <button class="btn-icon btn-deactivate" title="Deactivate"
                                                    onclick="toggleUserStatus({{ $user->id }})">
                                                    <i class="fas fa-user-slash"></i>
                                                </button>
                                            @else
                                                <button class="btn-icon btn-deactivate" title="Activate"
                                                    onclick="toggleUserStatus({{ $user->id }})"
                                                    style="background: rgba(40, 167, 69, 0.1); color: var(--success-color);">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            @endif
                                            @if ($user->id !== Auth::id())
                                                <button class="btn-icon btn-delete" title="Delete User"
                                                    onclick="deleteUser({{ $user->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-users fa-2x mb-3"></i>
                                            <p>No users found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($users->hasPages())
                    <div class="pagination-container">
                        <div class="pagination-info">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }}
                            entries
                        </div>
                        <nav>
                            {{ $users->links() }}
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus"></i>
                        Add New User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST" id="addUserForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter full name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Enter email address" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Role *</label>
                                    <select name="role" class="form-control" required>
                                        <option value="">Select Role</option>
                                        <option value="superadmin">Super Administrator</option>
                                        <option value="adminsales">Admin Sales</option>
                                        <option value="sales">Sales</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Initial Password *</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Enter initial password" required minlength="8">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control"
                                placeholder="Enter phone number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-add-user">
                            <i class="fas fa-plus me-2"></i>Add User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit"></i>
                        Edit User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="name" id="edit_name" class="form-control"
                                        placeholder="Enter full name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" id="edit_email" class="form-control"
                                        placeholder="Enter email address" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Role *</label>
                                    <select name="role" id="edit_role" class="form-control" required>
                                        <option value="">Select Role</option>
                                        <option value="superadmin">Super Administrator</option>
                                        <option value="adminsales">Admin Sales</option>
                                        <option value="sales">Sales</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone" id="edit_phone" class="form-control"
                                        placeholder="Enter phone number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="edit_is_active"
                                    name="is_active" value="1">
                                <label class="form-check-label" for="edit_is_active">Active User</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Change Password (Leave blank to keep current)</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Enter new password" minlength="8">
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-add-user">
                            <i class="fas fa-save me-2"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

        // Search functionality
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value;
                window.location.href = '{{ route('superadmin.welcome') }}?search=' + encodeURIComponent(
                searchTerm);
            }
        });

        // Open Edit Modal
        function openEditModal(userId, name, email, role, phone, isActive) {
            // Set form values
            document.getElementById('edit_user_id').value = userId;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_phone').value = phone || '';
            document.getElementById('edit_is_active').checked = isActive;

            // Set form action
            document.getElementById('editUserForm').action = '{{ route('admin.users.update') }}';

            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        }

        // User management functions
        function resetPassword(userId) {
            if (confirm('Are you sure you want to reset this user\'s password?')) {
                fetch('{{ route('admin.users.reset-password') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            user_id: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Password reset successfully');
                        } else {
                            alert('Error resetting password');
                        }
                    });
            }
        }

        function toggleUserStatus(userId) {
            if (confirm('Are you sure you want to change this user\'s status?')) {
                fetch('{{ route('admin.users.toggle-status') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            user_id: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error updating user status');
                        }
                    });
            }
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                fetch('{{ route('admin.users.destroy') }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            user_id: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error deleting user: ' + (data.message || 'Unknown error'));
                        }
                    });
            }
        }

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
