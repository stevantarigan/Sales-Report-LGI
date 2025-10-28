<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management | SuperAdmin</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-light: #818cf8;
            --secondary-color: #7c3aed;
            --accent-color: #8b5cf6;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --success-color: #10b981;
            --error-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
            --card-bg: rgba(255, 255, 255, 0.95);
            --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-warning: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --gradient-danger: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f4ff 0%, #f8fafc 50%, #f0fdf4 100%);
            min-height: 100vh;
            color: var(--dark-color);
            overflow-x: hidden;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.6;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: var(--primary-light);
            opacity: 0.1;
            animation: float 8s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
            background: var(--primary-light);
        }

        .shape:nth-child(2) {
            width: 100px;
            height: 100px;
            top: 70%;
            left: 85%;
            animation-delay: 1s;
            background: var(--info-color);
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 40%;
            left: 90%;
            animation-delay: 2s;
            background: var(--success-color);
        }

        .shape:nth-child(4) {
            width: 120px;
            height: 120px;
            top: 80%;
            left: 10%;
            animation-delay: 3s;
            background: var(--warning-color);
        }

        /* Layout */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            color: white;
            transition: var(--transition);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(79, 70, 229, 0.2);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .sidebar-logo {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            animation: pulse 2s infinite;
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.9rem 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: var(--transition);
            border-left: 4px solid transparent;
            margin: 0.2rem 0.5rem;
            border-radius: 8px;
        }

        .menu-item:hover,
        .menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: white;
            transform: translateX(5px);
            backdrop-filter: blur(10px);
        }

        .menu-item i {
            width: 20px;
            margin-right: 12px;
            font-size: 1.1rem;
            text-align: center;
        }

        .menu-text {
            font-weight: 500;
            flex: 1;
        }

        .menu-badge {
            background: rgba(255, 255, 255, 0.3);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            animation: bounce 2s infinite;
        }

        .menu-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 1.5rem;
        }

        .submenu {
            background: rgba(255, 255, 255, 0.05);
            margin: 0.5rem 1rem;
            border-radius: 8px;
            overflow: hidden;
            max-height: 0;
            transition: var(--transition);
        }

        .submenu.show {
            max-height: 500px;
        }

        .submenu-item {
            display: flex;
            align-items: center;
            padding: 0.7rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.85rem;
            transition: var(--transition);
            border-left: 2px solid transparent;
        }

        .submenu-item:hover,
        .submenu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: white;
            transform: translateX(3px);
        }

        .submenu-item i {
            font-size: 0.8rem;
            margin-right: 8px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            transition: var(--transition);
        }

        /* Top Navigation */
        .top-nav {
            background: rgba(255, 255, 255, 0.9);
            border-bottom: 1px solid rgba(229, 231, 235, 0.8);
            padding: 1.2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .nav-title h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-title p {
            color: #64748b;
            margin: 0;
            font-size: 0.9rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.6rem 1.2rem;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            transition: var(--transition);
            border: 1px solid rgba(229, 231, 235, 0.8);
            backdrop-filter: blur(10px);
        }

        .user-info:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .logout-btn {
            background: transparent;
            border: 1px solid var(--error-color);
            color: var(--error-color);
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: var(--transition);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        .logout-btn:hover {
            background: var(--error-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            padding: 1.8rem;
            text-align: center;
            transition: var(--transition);
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-primary);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
            background: var(--gradient-primary);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
            transition: var(--transition);
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Filter Section */
        .filter-section {
            background: white;
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            padding: 1.8rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(10px);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.2rem;
            align-items: end;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            background: white;
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .search-box {
            position: relative;
            min-width: 320px;
        }

        .search-box input {
            padding-left: 3rem;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            background: white;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 10px;
            padding: 0.8rem 1.8rem;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-success {
            background: var(--gradient-success);
            border: none;
            border-radius: 10px;
            padding: 0.8rem 1.8rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        /* Tables */
        .table-container {
            background: white;
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(10px);
        }

        .table-header {
            padding: 1.5rem;
            background: rgba(79, 70, 229, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .table {
            margin: 0;
        }

        .table th {
            background: rgba(79, 70, 229, 0.05);
            border-bottom: 2px solid rgba(79, 70, 229, 0.1);
            padding: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.9rem;
        }

        .table td {
            padding: 1.2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            vertical-align: middle;
            transition: var(--transition);
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background: rgba(79, 70, 229, 0.03);
            transform: translateX(8px);
        }

        /* Product Image */
        .product-img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            transition: var(--transition);
        }

        .product-img:hover {
            transform: scale(1.1);
            border-color: var(--primary-color);
        }

        /* Badges */
        .badge {
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .badge:hover {
            transform: scale(1.05);
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .badge-primary {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
            border: 1px solid rgba(79, 70, 229, 0.2);
        }

        .badge-secondary {
            background: rgba(100, 116, 139, 0.1);
            color: #64748b;
            border: 1px solid rgba(100, 116, 139, 0.2);
        }

        /* Stock Status */
        .stock-status.in-stock {
            color: var(--success-color);
            font-weight: 600;
            background: rgba(16, 185, 129, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        .stock-status.low-stock {
            color: var(--warning-color);
            font-weight: 600;
            background: rgba(245, 158, 11, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        .stock-status.out-of-stock {
            color: var(--error-color);
            font-weight: 600;
            background: rgba(239, 68, 68, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.6rem;
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
            position: relative;
            overflow: hidden;
        }

        .btn-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .btn-icon:hover::before {
            left: 100%;
        }

        .btn-icon-view {
            background: rgba(6, 182, 212, 0.1);
            color: var(--info-color);
            border: 1px solid rgba(6, 182, 212, 0.2);
        }

        .btn-icon-view:hover {
            background: var(--info-color);
            color: white;
            transform: scale(1.1) rotate(5deg);
        }

        .btn-icon-edit {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
            border: 1px solid rgba(79, 70, 229, 0.2);
        }

        .btn-icon-edit:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1) rotate(5deg);
        }

        .btn-icon-delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-icon-delete:hover {
            background: var(--error-color);
            color: white;
            transform: scale(1.1) rotate(-5deg);
        }

        /* Bulk Actions */
        .bulk-actions {
            background: rgba(79, 70, 229, 0.05);
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: var(--transition);
        }

        .bulk-actions:hover {
            background: rgba(79, 70, 229, 0.08);
        }

        /* Pagination */
        .pagination-container {
            padding: 1.2rem 1.5rem;
            background: rgba(79, 70, 229, 0.03);
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.5;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .empty-state h4 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .empty-state p {
            font-size: 1rem;
            margin-bottom: 2rem;
            color: #64748b;
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
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

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-5px);
            }

            60% {
                transform: translateY(-3px);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .sidebar .menu-text,
            .sidebar .sidebar-title,
            .sidebar .menu-badge {
                display: none;
            }

            .main-content {
                margin-left: 80px;
            }

            .top-nav {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .content-area {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-row {
                grid-template-columns: 1fr;
            }

            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                min-width: 100%;
            }

            .table-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
        }
    </style>
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
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="sidebar-title">SuperAdmin Panel</div>
            </div>

            <div class="sidebar-menu">
                <a href="{{ route('superadmin.welcome') }}" class="menu-item">
                    <i class="fas fa-home"></i>
                    <span class="menu-text">Dashboard</span>
                </a>

                <div class="menu-divider"></div>

                <a href="#" class="menu-item">
                    <i class="fas fa-box"></i>
                    <span class="menu-text">Product Management</span>
                    <span class="menu-badge">New</span>
                </a>

                <div class="submenu">
                    <a href="{{ route('products.index') }}" class="submenu-item active">
                        <i class="fas fa-list"></i>
                        All Products
                    </a>
                    <a href="{{ route('products.create') }}" class="submenu-item">
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

                <a href="#" class="menu-item">
                    <i class="fas fa-users"></i>
                    <span class="menu-text">User Management</span>
                </a>

                <a href="#" class="menu-item">
                    <i class="fas fa-chart-line"></i>
                    <span class="menu-text">Sales Analytics</span>
                </a>

                <a href="#" class="menu-item">
                    <i class="fas fa-cog"></i>
                    <span class="menu-text">Settings</span>
                </a>

                <div class="menu-divider"></div>

                <a href="#" class="menu-item">
                    <i class="fas fa-question-circle"></i>
                    <span class="menu-text">Help & Support</span>
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation -->
            <header class="top-nav">
                <div class="nav-title">
                    <h1>Product Management</h1>
                    <p>Manage your product inventory and catalog</p>
                </div>

                <div class="user-menu">
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 0.9rem;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 0.75rem; color: #64748b;">Super Administrator</div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content Area -->
            <main class="content-area">
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="stat-icon" style="background: var(--gradient-primary);">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="stat-value">{{ $totalProducts }}</div>
                        <div class="stat-label">Total Products</div>
                    </div>

                    <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-icon" style="background: var(--gradient-success);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-value">{{ $activeProducts }}</div>
                        <div class="stat-label">Active Products</div>
                    </div>

                    <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="stat-icon" style="background: var(--gradient-warning);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-value">{{ $lowStockProducts }}</div>
                        <div class="stat-label">Low Stock</div>
                    </div>

                    <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="stat-icon" style="background: var(--gradient-danger);">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stat-value">{{ $outOfStockProducts }}</div>
                        <div class="stat-label">Out of Stock</div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="filter-section" data-aos="fade-up" data-aos-delay="500">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="filter-row">
                            <div>
                                <label class="form-label">Search Products</label>
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by name, SKU, category..."
                                        value="{{ request('search') }}">
                                </div>
                            </div>

                            <div>
                                <label class="form-label">Category</label>
                                <select name="category" class="form-control">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}"
                                            {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                    <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>
                                        Featured</option>
                                    <option value="low_stock"
                                        {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                                    <option value="out_of_stock"
                                        {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Sort By</label>
                                <select name="sort" class="form-control">
                                    <option value="created_at"
                                        {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z
                                    </option>
                                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price
                                        Low-High</option>
                                    <option value="stock_quantity"
                                        {{ request('sort') == 'stock_quantity' ? 'selected' : '' }}>Stock Level
                                    </option>
                                </select>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Action Bar -->
                <div class="action-bar" data-aos="fade-up" data-aos-delay="600">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="quickSearch" class="form-control" placeholder="Quick search...">
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('products.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Add New Product
                        </a>
                        <button class="btn btn-primary" onclick="exportProducts()">
                            <i class="fas fa-download me-2"></i>Export
                        </button>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="table-container" data-aos="fade-up" data-aos-delay="700">
                    @if ($products->count() > 0)
                        <!-- Bulk Actions -->
                        <div class="bulk-actions">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">
                                    Select All
                                </label>
                            </div>
                            <select class="form-select form-select-sm" style="width: auto;"
                                onchange="handleBulkAction(this.value)">
                                <option value="">Bulk Actions</option>
                                <option value="activate">Activate</option>
                                <option value="deactivate">Deactivate</option>
                                <option value="feature">Mark as Featured</option>
                                <option value="unfeature">Remove Featured</option>
                                <option value="delete">Delete</option>
                            </select>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" class="form-check-input">
                                    </th>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Last Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr data-aos="fade-right" data-aos-delay="{{ $loop->index * 100 }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input product-checkbox"
                                                value="{{ $product->id }}">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}"
                                                        alt="{{ $product->name }}" class="product-img me-3">
                                                @else
                                                    <div
                                                        class="product-img me-3 bg-light d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-box text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div style="font-weight: 600;">{{ $product->name }}</div>
                                                    @if ($product->brand)
                                                        <small class="text-muted">{{ $product->brand }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <code>{{ $product->sku }}</code>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $product->category }}</span>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($product->price, 2) }}</strong>
                                            @if ($product->cost_price)
                                                <br>
                                                <small class="text-muted">
                                                    Cost: ${{ number_format($product->cost_price, 2) }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <span
                                                    class="stock-status 
                                                    @if ($product->stock_quantity == 0) out-of-stock
                                                    @elseif($product->stock_quantity <= $product->min_stock) low-stock
                                                    @else in-stock @endif">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                                <small class="text-muted d-block">
                                                    Min: {{ $product->min_stock }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($product->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product->is_featured)
                                                <span class="badge badge-primary">Featured</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $product->updated_at->format('M j, Y') }}
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('products.show', $product) }}"
                                                    class="btn-icon btn-icon-view" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product) }}"
                                                    class="btn-icon btn-icon-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('products.destroy', $product) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon btn-icon-delete"
                                                        title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10">
                                            <div class="empty-state">
                                                <i class="fas fa-box-open"></i>
                                                <h4>No products found</h4>
                                                <p>Get started by adding your first product to the catalog.</p>
                                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-2"></i>Add New Product
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($products->hasPages())
                        <div class="pagination-container">
                            <div class="text-muted">
                                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                                {{ $products->total() }} products
                            </div>
                            <nav>
                                {{ $products->links() }}
                            </nav>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

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

        // Quick search functionality
        document.getElementById('quickSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Select all functionality
        document.getElementById('selectAll').addEventListener('change', function(e) {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });

        // Bulk actions
        function handleBulkAction(action) {
            const selectedProducts = Array.from(document.querySelectorAll('.product-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedProducts.length === 0) {
                alert('Please select at least one product.');
                return;
            }

            if (action === 'delete') {
                if (!confirm(`Are you sure you want to delete ${selectedProducts.length} product(s)?`)) {
                    return;
                }
            }

            // Implement bulk action logic here
            console.log('Bulk action:', action, 'on products:', selectedProducts);

            // You would typically make an AJAX request here
            // fetch('/products/bulk-action', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //     },
            //     body: JSON.stringify({
            //         action: action,
            //         product_ids: selectedProducts
            //     })
            // }).then(...)
        }

        // Export functionality
        function exportProducts() {
            // Implement export logic here
            alert('Export functionality would be implemented here');
        }

        // Auto-hide bulk actions when no products are selected
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-checkbox')) {
                const selectedCount = document.querySelectorAll('.product-checkbox:checked').length;
                // You can add logic to show/hide bulk actions based on selection
            }
        });

        // Add ripple effect to buttons
        document.querySelectorAll('.btn-primary, .btn-success').forEach(button => {
            button.addEventListener('click', function(e) {
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
                `;

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>
