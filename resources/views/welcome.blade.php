@extends('superadmin.dashboard')


{{-- <!DOCTYPE html>
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
            transform: translateX(0);
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
            width: 0;
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
            white-space: nowrap;
            overflow: hidden;
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
            white-space: nowrap;
            overflow: hidden;
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
            flex-shrink: 0;
        }

        .menu-text {
            font-weight: 500;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-badge {
            background: rgba(255, 255, 255, 0.3);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            animation: bounce 2s infinite;
            flex-shrink: 0;
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
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
            flex-shrink: 0;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 0;
            transition: var(--transition);
            width: 100%;
        }

        .main-content.expanded {
            margin-left: 280px;
            width: calc(100% - 280px);
        }

        /* Top Navigation */
        .top-nav {
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid rgba(229, 231, 235, 0.8);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            flex-wrap: wrap;
            gap: 1rem;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-toggle {
            background: var(--gradient-primary);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .sidebar-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }

        .nav-title h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            white-space: nowrap;
        }

        .nav-title p {
            color: #64748b;
            margin: 0;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
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
            flex-shrink: 0;
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
            flex-shrink: 0;
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
            flex-shrink: 0;
        }

        .logout-btn:hover {
            background: var(--error-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
        }

        /* Content Area */
        .content-area {
            padding: 1.5rem;
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            overflow: hidden;
            width: 100%;
        }

        .card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            transform: translateY(-5px);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 1.25rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Metrics Grid */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .metric-card {
            background: white;
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: var(--transition);
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-primary);
        }

        .metric-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .metric-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            background: var(--gradient-primary);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
            transition: var(--transition);
            flex-shrink: 0;
        }

        .metric-card:hover .metric-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .metric-info {
            flex: 1;
            min-width: 0;
        }

        .metric-title {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .metric-value {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .metric-trend {
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .trend-up {
            color: var(--success-color);
        }

        .trend-down {
            color: var(--error-color);
        }

        /* Feature Cards */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .feature-card {
            background: white;
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            padding: 1.75rem;
            transition: var(--transition);
            cursor: pointer;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.6s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 65px;
            height: 65px;
            background: var(--gradient-primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.6rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
            transition: var(--transition);
            flex-shrink: 0;
        }

        .feature-card:hover .feature-icon {
            transform: rotate(10deg) scale(1.1);
            background: var(--gradient-secondary);
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.8rem;
        }

        .feature-description {
            color: #64748b;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.25rem;
        }

        .feature-action {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .feature-card:hover .feature-action {
            transform: translateX(8px);
            color: var(--secondary-color);
        }

        /* Tables */
        .table-container {
            background: white;
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(10px);
            width: 100%;
            overflow-x: auto;
        }

        .table-header {
            padding: 1.25rem;
            background: rgba(79, 70, 229, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
            white-space: nowrap;
        }

        .search-box {
            position: relative;
            min-width: 250px;
            flex: 1;
        }

        .search-box input {
            padding-left: 3rem;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
            width: 100%;
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
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            white-space: nowrap;
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

        .table {
            margin: 0;
            width: 100%;
            min-width: 800px;
        }

        .table th {
            background: rgba(79, 70, 229, 0.05);
            border-bottom: 2px solid rgba(79, 70, 229, 0.1);
            padding: 1rem;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            vertical-align: middle;
            transition: var(--transition);
            white-space: nowrap;
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background: rgba(79, 70, 229, 0.03);
            transform: translateX(8px);
        }

        /* Badges */
        .badge {
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 600;
            transition: var(--transition);
            white-space: nowrap;
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

        .badge-info {
            background: rgba(6, 182, 212, 0.1);
            color: var(--info-color);
            border: 1px solid rgba(6, 182, 212, 0.2);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
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

        .btn-icon-reset {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .btn-icon-reset:hover {
            background: var(--warning-color);
            color: white;
            transform: scale(1.1) rotate(5deg);
        }

        /* Pagination */
        .pagination-container {
            padding: 1rem 1.25rem;
            background: rgba(79, 70, 229, 0.03);
            border-top: 1px solid rgba(0, 0, 0, 0.06);
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

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes typewriter {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        @keyframes blink {

            0%,
            50% {
                opacity: 1;
            }

            51%,
            100% {
                opacity: 0;
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .metrics-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content.expanded {
                margin-left: 0;
                width: 100%;
            }

            .top-nav {
                padding: 1rem;
            }

            .nav-title h1 {
                font-size: 1.2rem;
            }

            .nav-title p {
                font-size: 0.8rem;
            }

            .content-area {
                padding: 1rem;
            }

            .metrics-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .feature-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .search-box {
                min-width: 100%;
            }

            .user-menu {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 576px) {
            .metric-card {
                flex-direction: column;
                text-align: center;
                padding: 1.25rem;
            }

            .metric-icon {
                margin-bottom: 0.75rem;
            }

            .feature-card {
                padding: 1.5rem;
            }

            .feature-icon {
                width: 55px;
                height: 55px;
                font-size: 1.4rem;
            }

            .feature-title {
                font-size: 1.1rem;
            }

            .card-header,
            .card-body {
                padding: 1rem;
            }

            .table-header {
                padding: 1rem;
            }

            .table th,
            .table td {
                padding: 0.75rem;
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
                <a href="{{ url('/') }}" class="menu-item active">
                    <i class="fas fa-home"></i>
                    <span class="menu-text">Dashboard</span>
                </a>

                <div class="menu-divider"></div>

                <a href="#" class="menu-item" id="userManagementMenu">
                    <i class="fas fa-users"></i>
                    <span class="menu-text">User Management</span>
                    <span class="menu-badge">New</span>
                </a>

                <div class="submenu" id="userSubmenu">
                    <a href="{{ url('/users') }}" class="submenu-item">
                        <i class="fas fa-list"></i>
                        All Users
                    </a>
                    <a href="{{ url('/users/create') }}" class="submenu-item">
                        <i class="fas fa-plus"></i>
                        Add New User
                    </a>
                    <a href="#" class="submenu-item">
                        <i class="fas fa-user-shield"></i>
                        User Roles
                    </a>
                    <a href="#" class="submenu-item">
                        <i class="fas fa-chart-bar"></i>
                        User Analytics
                    </a>
                </div>

                <a href="#" class="menu-item" id="productManagementMenu">
                    <i class="fas fa-box"></i>
                    <span class="menu-text">Product Management</span>
                </a>

                <div class="submenu" id="productSubmenu">
                    <a href="{{ url('/products') }}" class="submenu-item">
                        <i class="fas fa-list"></i>
                        All Products
                    </a>
                    <a href="{{ url('/products/create') }}" class="submenu-item">
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

                <div class="menu-divider"></div>

                <a href="#" class="menu-item">
                    <i class="fas fa-cog"></i>
                    <span class="menu-text">Settings</span>
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Top Navigation -->
            <header class="top-nav">
                <div class="nav-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="nav-title">
                        <h1 id="typing-title">Dashboard Overview</h1>
                        <p>Welcome back, Admin. Here's what's happening today.</p>
                    </div>
                </div>

                <div class="user-menu">
                    <div class="user-info">
                        <div class="user-avatar">
                            A
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 0.9rem;">Admin User</div>
                            <div style="font-size: 0.75rem; color: #64748b;">Super Administrator</div>
                        </div>
                    </div>
                    <form action="{{ url('/logout') }}" method="POST" class="d-inline">
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
                <!-- Metrics Grid -->
                <div class="metrics-grid">
                    <div class="metric-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="metric-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Total Users</div>
                            <div class="metric-value">1,248</div>
                            <div class="metric-trend trend-up">
                                <i class="fas fa-arrow-up"></i>
                                +12.5% from last month
                            </div>
                        </div>
                    </div>

                    <div class="metric-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="metric-icon" style="background: var(--gradient-success);">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Active Users</div>
                            <div class="metric-value">984</div>
                            <div class="metric-trend trend-up">
                                <i class="fas fa-arrow-up"></i>
                                +8.3% from last month
                            </div>
                        </div>
                    </div>

                    <div class="metric-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="metric-icon" style="background: var(--gradient-warning);">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">New This Month</div>
                            <div class="metric-value">156</div>
                            <div class="metric-trend trend-up">
                                <i class="fas fa-arrow-up"></i>
                                +5.2% from last month
                            </div>
                        </div>
                    </div>

                    <div class="metric-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="metric-icon" style="background: var(--gradient-secondary);">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-title">Admin Users</div>
                            <div class="metric-value">24</div>
                            <div class="metric-trend trend-up">
                                <i class="fas fa-arrow-up"></i>
                                +2 from last month
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="feature-grid">
                    <div class="feature-card" onclick="createContact()" data-aos="zoom-in" data-aos-delay="100">
                        <div class="feature-icon">
                            <i class="fas fa-address-book"></i>
                        </div>
                        <h3 class="feature-title">Create your first contact</h3>
                        <p class="feature-description">Growing your sales starts with contacts. Let's walk through it.
                        </p>
                        <div class="feature-action">
                            <span>Get Started</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>

                    <div class="feature-card" onclick="createLead()" data-aos="zoom-in" data-aos-delay="200">
                        <div class="feature-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h3 class="feature-title">Create your first lead</h3>
                        <p class="feature-description">Let us show you how easy it is to convert your leads into
                            contacts, accounts, and opportunities.</p>
                        <div class="feature-action">
                            <span>Get Started</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>

                    <div class="feature-card" onclick="enableMarketing()" data-aos="zoom-in" data-aos-delay="300">
                        <div class="feature-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h3 class="feature-title">Turn on marketing features</h3>
                        <p class="feature-description">Access powerful tools to reach new audiences and engage
                            customers.</p>
                        <div class="feature-action">
                            <span>Get Started</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </div>

                <!-- User Management Section -->
                <div class="card" data-aos="fade-up" data-aos-delay="400">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-users-cog"></i>
                            User Management
                        </h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-header">
                            <h3 class="table-title">All System Users (24)</h3>
                            <div class="d-flex gap-3 flex-wrap" style="flex: 1; min-width: 300px;">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" class="form-control" id="searchInput"
                                        placeholder="Search users...">
                                </div>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addUserModal">
                                    <i class="fas fa-plus me-2"></i>Add User
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Last Login</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-aos="fade-right" data-aos-delay="100">
                                        <td>USR001</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3">
                                                    J
                                                </div>
                                                <div>
                                                    <div style="font-weight: 600;">John Doe</div>
                                                    <small class="text-muted">Registered: Jan 15, 2023</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>john.doe@example.com</td>
                                        <td>
                                            <span class="badge badge-primary">SuperAdmin</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            Dec 10, 2023 14:30
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-icon btn-icon-edit" title="Edit User">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-reset" title="Reset Password">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-delete" title="Delete User">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-aos="fade-right" data-aos-delay="200">
                                        <td>USR002</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3">
                                                    S
                                                </div>
                                                <div>
                                                    <div style="font-weight: 600;">Sarah Smith</div>
                                                    <small class="text-muted">Registered: Feb 20, 2023</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>sarah.smith@example.com</td>
                                        <td>
                                            <span class="badge badge-success">AdminSales</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            Dec 12, 2023 09:15
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-icon btn-icon-edit" title="Edit User">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-reset" title="Reset Password">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-delete" title="Delete User">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-aos="fade-right" data-aos-delay="300">
                                        <td>USR003</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3">
                                                    M
                                                </div>
                                                <div>
                                                    <div style="font-weight: 600;">Mike Johnson</div>
                                                    <small class="text-muted">Registered: Mar 5, 2023</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>mike.johnson@example.com</td>
                                        <td>
                                            <span class="badge badge-warning">Sales</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger">Inactive</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">Never</span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-icon btn-icon-edit" title="Edit User">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-reset" title="Reset Password">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-delete" title="Delete User">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-container">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="text-muted">
                                    Showing 1 to 3 of 24 entries
                                </div>
                                <nav>
                                    <ul class="pagination mb-0">
                                        <li class="page-item disabled"><a class="page-link"
                                                href="#">Previous</a></li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

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
                <form id="addUserForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter full name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Enter email address" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
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
                                <div class="mb-3">
                                    <label class="form-label">Initial Password *</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Enter initial password" required minlength="8">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control"
                                placeholder="Enter phone number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add User
                        </button>
                    </div>
                </form>
            </div>
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

        // Sidebar toggle functionality
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');

            // Change icon based on state
            const icon = sidebarToggle.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-bars');
            } else {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            }
        });

        // Menu toggle functionality
        const userMenu = document.getElementById('userManagementMenu');
        const userSubmenu = document.getElementById('userSubmenu');
        const productMenu = document.getElementById('productManagementMenu');
        const productSubmenu = document.getElementById('productSubmenu');

        userMenu.addEventListener('click', function(e) {
            e.preventDefault();
            userSubmenu.classList.toggle('show');
            // Close other submenu if open
            if (productSubmenu.classList.contains('show')) {
                productSubmenu.classList.remove('show');
            }
        });

        productMenu.addEventListener('click', function(e) {
            e.preventDefault();
            productSubmenu.classList.toggle('show');
            // Close other submenu if open
            if (userSubmenu.classList.contains('show')) {
                userSubmenu.classList.remove('show');
            }
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value;
                alert('Searching for: ' + searchTerm);
                // In a real application, you would make an API call or redirect
            }
        });

        // Typing animation for title
        const typingTitle = document.getElementById('typing-title');
        if (typingTitle) {
            const text = typingTitle.textContent;
            typingTitle.textContent = '';
            typingTitle.style.borderRight = '2px solid var(--primary-color)';

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

        // Feature card functions
        function createContact() {
            alert('Create Contact functionality would be implemented here');
        }

        function createLead() {
            alert('Create Lead functionality would be implemented here');
        }

        function enableMarketing() {
            alert('Marketing Features functionality would be implemented here');
        }

        // Add ripple effect to buttons
        document.querySelectorAll('.btn-primary').forEach(button => {
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

        // Handle window resize for responsive behavior
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.remove('expanded');
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.add('expanded');
            }
        });

        // Initialize responsive state
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.remove('expanded');
        } else {
            sidebar.classList.remove('collapsed');
            mainContent.classList.add('expanded');
        }
    </script>
</body>

</html> --}}
