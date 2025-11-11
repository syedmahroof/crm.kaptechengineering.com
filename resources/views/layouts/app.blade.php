<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Lead Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
        }
        
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        body {
            background: #f1f5f9;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: #ffffff;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.08);
            z-index: 1000;
            overflow-y: auto;
            border-right: 1px solid #e2e8f0;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .sidebar-brand {
            padding: 28px 24px;
            border-bottom: 1px solid #f1f5f9;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }
        
        .sidebar-brand h4 {
            margin: 0;
            color: white;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        
        .sidebar-brand small {
            color: rgba(255,255,255,0.8);
            font-size: 12px;
            font-weight: 500;
        }
        
        .sidebar-nav {
            padding: 16px 12px;
        }
        
        .nav-section-title {
            padding: 20px 12px 8px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #94a3b8;
        }
        
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            margin: 3px 0;
            color: #64748b;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .sidebar .nav-link:hover {
            background: #f8fafc;
            color: var(--primary);
            transform: translateX(4px);
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .sidebar .nav-link.active i {
            transform: scale(1.1);
        }
        
        /* Sub-menu styles */
        .nav-group {
            margin: 3px 0;
        }
        
        .nav-group-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            color: #64748b;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            background: transparent;
            border: none;
            width: 100%;
            margin: 3px 0;
        }
        
        .nav-group-toggle .bi-chevron-down {
            width: 16px;
            margin-left: 8px;
            flex-shrink: 0;
            font-size: 12px;
            transition: transform 0.3s;
        }
        
        .nav-group-toggle:hover {
            background: #f8fafc;
            color: var(--primary);
        }
        
        
        .nav-group.active .nav-group-toggle .bi-chevron-down {
            transform: rotate(180deg);
        }
        
        .nav-group-toggle-left {
            display: flex;
            align-items: center;
            flex: 1;
        }
        
        .nav-group-toggle-left i {
            width: 20px;
            margin-right: 12px;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .nav-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            padding-left: 0;
            margin-top: 4px;
        }
        
        .nav-group.active .nav-submenu {
            max-height: 500px;
        }
        
        .nav-submenu .nav-link {
            padding: 10px 16px 10px 40px;
            font-size: 13px;
            margin: 2px 0;
        }
        
        .nav-submenu .nav-link i {
            width: 18px;
            margin-right: 10px;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 0;
            min-height: 100vh;
        }
        
        .content-wrapper {
            padding: 0 32px 32px 32px;
        }
        
        /* Top Bar */
        .top-bar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 0;
            margin: 0 0 24px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: box-shadow 0.2s;
            overflow: visible;
        }
        
        .top-bar.scrolled {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .top-bar .content-wrapper {
            position: relative;
        }
        
        .page-title {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }
        
        .page-subtitle {
            color: #64748b;
            font-size: 13px;
            margin: 6px 0 0;
            font-weight: 500;
            line-height: 1.4;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-menu .dropdown {
            position: relative;
        }
        
        .notification-btn {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #f8fafc;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 18px;
            position: relative;
            transition: all 0.2s;
            text-decoration: none;
            cursor: pointer;
        }
        
        .notification-btn:hover {
            background: #f1f5f9;
            color: var(--primary);
            transform: translateY(-2px);
        }
        
        .notification-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            min-width: 18px;
            height: 18px;
            background: #ef4444;
            border-radius: 10px;
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            color: white;
            padding: 0 4px;
        }
        
        .notification-dropdown {
            position: absolute !important;
            top: 100%;
            right: 0;
            margin-top: 8px;
            padding: 0;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border-radius: 16px;
            background: white;
            z-index: 1050;
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .notification-dropdown.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        
        .notification-dropdown .dropdown-item {
            padding: 0;
            border: none;
            transition: all 0.2s ease;
        }
        
        .notification-dropdown-item {
            text-decoration: none;
            display: block;
            transition: all 0.2s ease;
        }
        
        .notification-dropdown-item:hover {
            background: #f1f5f9 !important;
            transform: translateX(4px);
        }
        
        .notification-dropdown::-webkit-scrollbar {
            width: 6px;
        }
        
        .notification-dropdown::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .notification-dropdown::-webkit-scrollbar-track {
            background: transparent;
        }
        
        /* Notification dropdown animation */
        @keyframes notificationSlideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .notification-dropdown.animating {
            animation: notificationSlideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Pulse animation for unread indicator */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.1);
            }
        }
        
        /* Bell shake animation for unread notifications */
        @keyframes bellShake {
            0%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(-10deg); }
            20%, 40% { transform: rotate(10deg); }
            50% { transform: rotate(0deg); }
        }
        
        .notification-btn:has(.notification-badge) .bi-bell-fill {
            animation: bellShake 2s ease-in-out infinite;
            animation-delay: 3s;
        }
        
        .user-dropdown-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        
        .user-dropdown-btn:hover {
            border-color: var(--primary);
            background: white;
        }
        
        .user-menu .dropdown-menu {
            position: absolute !important;
            top: 100%;
            right: 0;
            margin-top: 8px;
            z-index: 1050;
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .user-menu .dropdown-menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 13px;
        }
        
        .user-info {
            text-align: left;
        }
        
        .user-name {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
        }
        
        .user-role {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }
        
        /* Cards */
        .card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
            transition: all 0.2s;
            overflow: hidden;
        }
        
        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }
        
        .card-header {
            background: #fafbfc;
            border-bottom: 1px solid #e2e8f0;
            padding: 20px 28px;
        }
        
        .card-header h5 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }
        
        .card-body {
            padding: 28px;
        }
        
        /* Stat Cards */
        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }
        
        .stat-card-inline {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        
        .stat-content {
            flex: 1;
            min-width: 0;
        }
        
        .stat-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }
        
        .stat-change {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .stat-change.positive {
            background: #d1fae5;
            color: #065f46;
        }
        
        /* Buttons */
        .btn {
            font-weight: 600;
            border-radius: 10px;
            padding: 10px 24px;
            transition: all 0.2s;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: white;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Tables */
        .table {
            font-size: 14px;
        }
        
        .table thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.8px;
            border: none;
            padding: 16px 20px;
        }
        
        .table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }
        
        .table tbody tr {
            transition: all 0.2s;
        }
        
        .table tbody tr:hover {
            background: #f8fafc;
        }
        
        /* Badges */
        .badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.3px;
        }
        
        /* Forms */
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #334155;
            margin-bottom: 8px;
        }
        
        /* Page Content Spacing */
        .content-section {
            margin-bottom: 28px;
        }
        
        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 28px;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        
        /* Dropdown */
        .dropdown-menu {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            padding: 8px;
            margin-top: 8px;
        }
        
        .dropdown-item {
            border-radius: 8px;
            padding: 10px 16px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background: #f8fafc;
        }
        
        .dropdown-item i {
            width: 20px;
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
            display: none;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
            z-index: 1001;
            transition: all 0.3s;
        }
        
        .mobile-menu-toggle:active {
            transform: scale(0.95);
        }
        
        /* Mobile Sidebar Backdrop */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .sidebar-backdrop.show {
            display: block;
            opacity: 1;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 0;
            }
            
            .content-wrapper {
                padding: 0 20px 20px 20px;
            }
            
            .mobile-menu-toggle {
                display: flex;
            }
            
            .top-bar {
                padding: 16px 0;
            }
            
            .top-bar .content-wrapper {
                padding-left: 20px;
                padding-right: 20px;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .page-subtitle {
                font-size: 12px;
            }
            
            .stat-card {
                margin-bottom: 16px;
            }
        }
        
        @media (max-width: 768px) {
            .user-menu {
                gap: 8px;
            }
            
            .notification-btn {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
            
            .notification-dropdown {
                width: calc(100vw - 40px) !important;
                max-width: 380px;
                right: 0 !important;
                left: auto !important;
            }
            
            .notification-dropdown.show {
                display: block !important;
            }
            
            .user-dropdown-btn {
                padding: 6px 12px;
            }
            
            .user-avatar {
                width: 32px;
                height: 32px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Mobile Sidebar Backdrop -->
    <div class="sidebar-backdrop" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-brand">
            <h4><i class="bi bi-lightning-charge-fill me-2"></i>LeadFlow</h4>
            <small>Lead Management System</small>
        </div>
        
        <div class="sidebar-nav">
            <!-- Dashboard -->
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- Lead Management -->
            <div class="nav-group {{ request()->routeIs('leads.*') || request()->routeIs('followups.*') || request()->routeIs('calendar.*') || request()->routeIs('todos.*') || request()->routeIs('analytics.*') || request()->routeIs('lead-types.*') || request()->routeIs('lead-sources.*') ? 'active' : '' }}">
                <button class="nav-group-toggle" onclick="this.parentElement.classList.toggle('active')">
                    <div class="nav-group-toggle-left">
                        <i class="bi bi-people-fill"></i>
                        <span>Lead Management</span>
                    </div>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="nav-submenu">
                    <a class="nav-link {{ request()->routeIs('leads.*') ? 'active' : '' }}" href="{{ route('leads.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Leads</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('followups.*') ? 'active' : '' }}" href="{{ route('followups.index') }}">
                        <i class="bi bi-calendar-check"></i>
                        <span>Follow-ups</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('calendar.*') ? 'active' : '' }}" href="{{ route('calendar.index') }}">
                        <i class="bi bi-calendar-event"></i>
                        <span>Calendar</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('todos.*') ? 'active' : '' }}" href="{{ route('todos.index') }}">
                        <i class="bi bi-check2-square"></i>
                        <span>Todo List</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('analytics.*') ? 'active' : '' }}" href="{{ route('analytics.index') }}">
                        <i class="bi bi-graph-up"></i>
                        <span>Analytics</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('lead-types.*') ? 'active' : '' }}" href="{{ route('lead-types.index') }}">
                        <i class="bi bi-tag-fill"></i>
                        <span>Lead Type</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('lead-sources.*') ? 'active' : '' }}" href="{{ route('lead-sources.index') }}">
                        <i class="bi bi-funnel-fill"></i>
                        <span>Lead Source</span>
                    </a>
                </div>
            </div>
            
            <!-- Product Management -->
            <div class="nav-group {{ request()->routeIs('products.*') || request()->routeIs('categories.*') || request()->routeIs('brands.*') ? 'active' : '' }}">
                <button class="nav-group-toggle" onclick="this.parentElement.classList.toggle('active')">
                    <div class="nav-group-toggle-left">
                        <i class="bi bi-box-seam-fill"></i>
                        <span>Products</span>
                    </div>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="nav-submenu">
                    <a class="nav-link {{ request()->routeIs('products.index') || request()->routeIs('products.create') || request()->routeIs('products.edit') || request()->routeIs('products.show') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Products</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('products.analytics') ? 'active' : '' }}" href="{{ route('products.analytics') }}">
                        <i class="bi bi-graph-up"></i>
                        <span>Product Analytics</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                        <i class="bi bi-tag"></i>
                        <span>Categories</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}" href="{{ route('brands.index') }}">
                        <i class="bi bi-award"></i>
                        <span>Brands</span>
                    </a>
                </div>
            </div>
            
            <!-- Master -->
            <div class="nav-group {{ request()->routeIs('countries.*') || request()->routeIs('states.*') || request()->routeIs('cities.*') ? 'active' : '' }}">
                <button class="nav-group-toggle" onclick="this.parentElement.classList.toggle('active')">
                    <div class="nav-group-toggle-left">
                        <i class="bi bi-gear-fill"></i>
                        <span>Master</span>
                    </div>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="nav-submenu">
                    <a class="nav-link {{ request()->routeIs('countries.*') ? 'active' : '' }}" href="{{ route('countries.index') }}">
                        <i class="bi bi-globe"></i>
                        <span>Country</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('states.*') ? 'active' : '' }}" href="{{ route('states.index') }}">
                        <i class="bi bi-geo-alt"></i>
                        <span>State</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('cities.*') ? 'active' : '' }}" href="{{ route('cities.index') }}">
                        <i class="bi bi-building"></i>
                        <span>City</span>
                    </a>
                </div>
            </div>
          
            <!-- Administration -->
            <div class="nav-group {{ request()->routeIs('branches.*') || request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'active' : '' }}">
                <button class="nav-group-toggle" onclick="this.parentElement.classList.toggle('active')">
                    <div class="nav-group-toggle-left">
                        <i class="bi bi-building-fill"></i>
                        <span>Administration</span>
                    </div>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="nav-submenu">
                    <a class="nav-link {{ request()->routeIs('branches.*') ? 'active' : '' }}" href="{{ route('branches.index') }}">
                        <i class="bi bi-building"></i>
                        <span>Branches</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="bi bi-person-fill-gear"></i>
                        <span>Users</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <i class="bi bi-shield-fill-check"></i>
                        <span>Roles & Permissions</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="content-wrapper" style="width: 100%; padding-top: 0; padding-bottom: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <div>
                        <h1 class="page-title">{{ $title ?? 'Dashboard' }}</h1>
                        <p class="page-subtitle">{{ $subtitle ?? 'Welcome back!' }}</p>
                    </div>
            
            <div class="user-menu">
                <!-- Quick Calendar Access -->
                <a href="{{ route('calendar.index') }}" class="notification-btn" title="Quick Calendar">
                    <i class="bi bi-calendar-week"></i>
                </a>
                
                <!-- Notifications -->
                <div class="dropdown">
                    <button class="notification-btn" aria-expanded="false" id="notificationDropdown" title="Notifications">
                        <i class="bi bi-bell-fill"></i>
                        @if(Auth::user()->unreadNotifications()->count() > 0)
                        <span class="notification-badge" id="notificationCount">{{ Auth::user()->unreadNotifications()->count() }}</span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown" style="width: 400px; max-height: 500px; overflow-y: auto;">
                        <div class="dropdown-header d-flex justify-content-between align-items-center" style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);">
                            <h6 class="mb-0 fw-bold" style="color: #0f172a; font-size: 15px;">
                                <i class="bi bi-bell-fill me-2" style="color: var(--primary);"></i>Notifications
                            </h6>
                            <a href="{{ route('notifications.index') }}" class="text-primary" style="font-size: 12px; text-decoration: none; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                View All →
                            </a>
                        </div>
                        <div id="notificationList">
                            @forelse(Auth::user()->notifications()->take(5)->get() as $notification)
                            <a href="{{ $notification->action_url ?? '#' }}" class="dropdown-item notification-dropdown-item" style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9; {{ $notification->is_read ? '' : 'background: linear-gradient(to right, #f8fafc 0%, #ffffff 100%);' }} position: relative; overflow: hidden;">
                                <div class="d-flex gap-3" style="position: relative; z-index: 1;">
                                    <div style="width: 44px; height: 44px; border-radius: 12px; background: var(--{{ $notification->color }})15; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid var(--{{ $notification->color }})30; transition: all 0.2s;">
                                        <i class="bi bi-{{ $notification->icon }}" style="font-size: 18px; color: var(--{{ $notification->color }});"></i>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div class="fw-bold" style="font-size: 13px; color: #0f172a; margin-bottom: 3px; line-height: 1.4;">{{ $notification->title }}</div>
                                        <div class="text-muted" style="font-size: 12px; line-height: 1.5; margin-bottom: 4px;">{{ Str::limit($notification->message, 65) }}</div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-clock" style="font-size: 10px; color: #94a3b8;"></i>
                                            <span class="text-muted" style="font-size: 11px; font-weight: 500; color: #64748b;">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    @if(!$notification->is_read)
                                    <div style="width: 8px; height: 8px; border-radius: 50%; background: #6366f1; margin-top: 6px; flex-shrink: 0; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15); animation: pulse 2s infinite;"></div>
                                    @endif
                                </div>
                            </a>
                            @empty
                            <div class="text-center py-5" style="opacity: 0.5;">
                                <i class="bi bi-bell-slash" style="font-size: 40px; display: block; margin-bottom: 12px; color: #cbd5e1;"></i>
                                <p class="fw-bold mb-1" style="color: #64748b;">No notifications yet</p>
                                <small class="text-muted" style="font-size: 12px;">You'll see notifications here when there's activity</small>
                            </div>
                            @endforelse
                        </div>
                        @if(Auth::user()->notifications()->count() > 0)
                        <div class="dropdown-footer text-center" style="padding: 14px 24px; border-top: 1px solid #e2e8f0; background: #f8fafc;">
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary w-100" style="font-weight: 600; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(99, 102, 241, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                    <i class="bi bi-check-all me-2"></i>Mark All as Read
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="user-dropdown-btn" id="userDropdown" aria-expanded="false">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="user-info d-none d-md-block">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">{{ Auth::user()->roles->first()->name ?? 'User' }}</div>
                        </div>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-circle"></i> My Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
                </div>
            </div>
        </div>

        <!-- Page Content Wrapper -->
        <div class="content-wrapper">
            <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

            <!-- Page Content -->
            {{ $slot }}
        </div>
    </main>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <!-- jQuery (optional utilities/plugins) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS (for dropdowns, modals, grid helpers) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.querySelector('.sidebar-backdrop');
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('show');
        }
        
        // Add scrolled class to top bar on scroll
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            const topBar = document.querySelector('.top-bar');
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 10) {
                topBar.classList.add('scrolled');
            } else {
                topBar.classList.remove('scrolled');
            }
            
            lastScrollTop = scrollTop;
        }, false);
        
        // Auto-open sub-menus for active items
        document.addEventListener('DOMContentLoaded', function() {
            const activeGroups = document.querySelectorAll('.nav-group.active');
            activeGroups.forEach(group => {
                // Don't auto-toggle here, let the user click
            });
        });
        
        // Notification dropdown hover and click functionality
        (function() {
            const notificationBtn = document.getElementById('notificationDropdown');
            const notificationDropdown = document.querySelector('.notification-dropdown');
            let hoverTimeout;
            let isDropdownOpen = false;
            
            if (!notificationBtn || !notificationDropdown) return;
            
            // Get the parent dropdown element
            const dropdownParent = notificationBtn.closest('.dropdown');
            
            // Check if device is touch-enabled
            const isTouchDevice = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);
            
            // Function to show dropdown
            function showDropdown() {
                clearTimeout(hoverTimeout);
                if (!isDropdownOpen) {
                    notificationDropdown.classList.add('show', 'animating');
                    notificationBtn.setAttribute('aria-expanded', 'true');
                    isDropdownOpen = true;
                    
                    // Remove animating class after animation completes
                    setTimeout(() => {
                        notificationDropdown.classList.remove('animating');
                    }, 300);
                }
            }
            
            // Function to hide dropdown
            function hideDropdown() {
                hoverTimeout = setTimeout(() => {
                    if (isDropdownOpen) {
                        notificationDropdown.classList.remove('show', 'animating');
                        notificationBtn.setAttribute('aria-expanded', 'false');
                        isDropdownOpen = false;
                    }
                }, 200); // Small delay before hiding
            }
            
            // Only enable hover functionality on non-touch devices
            if (!isTouchDevice) {
                // Hover on button
                notificationBtn.addEventListener('mouseenter', function() {
                    hoverTimeout = setTimeout(() => {
                        showDropdown();
                    }, 300); // Delay before showing on hover
                });
                
                notificationBtn.addEventListener('mouseleave', function(e) {
                    // Check if mouse is moving to dropdown
                    const rect = notificationDropdown.getBoundingClientRect();
                    const mouseX = e.clientX;
                    const mouseY = e.clientY;
                    
                    // If mouse is heading towards dropdown, don't hide yet
                    if (mouseX >= rect.left && mouseX <= rect.right && 
                        mouseY >= rect.top && mouseY <= rect.bottom) {
                        clearTimeout(hoverTimeout);
                    } else {
                        hideDropdown();
                    }
                });
                
                // Hover on dropdown
                notificationDropdown.addEventListener('mouseenter', function() {
                    clearTimeout(hoverTimeout);
                    showDropdown();
                });
                
                notificationDropdown.addEventListener('mouseleave', function() {
                    hideDropdown();
                });
            }
            
            // Click to toggle
            notificationBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                clearTimeout(hoverTimeout);
                
                if (isDropdownOpen) {
                    hideDropdown();
                    clearTimeout(hoverTimeout); // Clear delay
                    if (isDropdownOpen) {
                        notificationDropdown.classList.remove('show', 'animating');
                        notificationBtn.setAttribute('aria-expanded', 'false');
                        isDropdownOpen = false;
                    }
                } else {
                    showDropdown();
                }
            });
            
            // Close on outside click
            document.addEventListener('click', function(e) {
                if (!dropdownParent.contains(e.target) && isDropdownOpen) {
                    hideDropdown();
                    clearTimeout(hoverTimeout); // Clear delay
                    if (isDropdownOpen) {
                        notificationDropdown.classList.remove('show', 'animating');
                        notificationBtn.setAttribute('aria-expanded', 'false');
                        isDropdownOpen = false;
                    }
                }
            });
            
            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isDropdownOpen) {
                    hideDropdown();
                    clearTimeout(hoverTimeout);
                    if (isDropdownOpen) {
                        notificationDropdown.classList.remove('show', 'animating');
                        notificationBtn.setAttribute('aria-expanded', 'false');
                        isDropdownOpen = false;
                    }
                }
            });
        })();
        
        // User dropdown hover and click functionality
        (function() {
            const userBtn = document.getElementById('userDropdown');
            const userDropdown = document.querySelector('.user-dropdown-menu');
            let hoverTimeout;
            let isDropdownOpen = false;
            
            if (!userBtn || !userDropdown) return;
            
            // Get the parent dropdown element
            const dropdownParent = userBtn.closest('.dropdown');
            
            // Check if device is touch-enabled
            const isTouchDevice = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);
            
            // Function to show dropdown
            function showDropdown() {
                clearTimeout(hoverTimeout);
                if (!isDropdownOpen) {
                    userDropdown.classList.add('show');
                    userBtn.setAttribute('aria-expanded', 'true');
                    isDropdownOpen = true;
                }
            }
            
            // Function to hide dropdown
            function hideDropdown() {
                hoverTimeout = setTimeout(() => {
                    if (isDropdownOpen) {
                        userDropdown.classList.remove('show');
                        userBtn.setAttribute('aria-expanded', 'false');
                        isDropdownOpen = false;
                    }
                }, 200);
            }
            
            // Only enable hover functionality on non-touch devices
            if (!isTouchDevice) {
                // Hover on button
                userBtn.addEventListener('mouseenter', function() {
                    hoverTimeout = setTimeout(() => {
                        showDropdown();
                    }, 300);
                });
                
                userBtn.addEventListener('mouseleave', function(e) {
                    const rect = userDropdown.getBoundingClientRect();
                    const mouseX = e.clientX;
                    const mouseY = e.clientY;
                    
                    if (mouseX >= rect.left && mouseX <= rect.right && 
                        mouseY >= rect.top && mouseY <= rect.bottom) {
                        clearTimeout(hoverTimeout);
                    } else {
                        hideDropdown();
                    }
                });
                
                // Hover on dropdown
                userDropdown.addEventListener('mouseenter', function() {
                    clearTimeout(hoverTimeout);
                    showDropdown();
                });
                
                userDropdown.addEventListener('mouseleave', function() {
                    hideDropdown();
                });
            }
            
            // Click to toggle
            userBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                clearTimeout(hoverTimeout);
                
                if (isDropdownOpen) {
                    hideDropdown();
                    clearTimeout(hoverTimeout);
                    if (isDropdownOpen) {
                        userDropdown.classList.remove('show');
                        userBtn.setAttribute('aria-expanded', 'false');
                        isDropdownOpen = false;
                    }
                } else {
                    showDropdown();
                }
            });
            
            // Close on outside click
            document.addEventListener('click', function(e) {
                if (!dropdownParent.contains(e.target) && isDropdownOpen) {
                    hideDropdown();
                    clearTimeout(hoverTimeout);
                    if (isDropdownOpen) {
                        userDropdown.classList.remove('show');
                        userBtn.setAttribute('aria-expanded', 'false');
                        isDropdownOpen = false;
                    }
                }
            });
            
            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isDropdownOpen) {
                    hideDropdown();
                    clearTimeout(hoverTimeout);
                    if (isDropdownOpen) {
                        userDropdown.classList.remove('show');
                        userBtn.setAttribute('aria-expanded', 'false');
                        isDropdownOpen = false;
                    }
                }
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>
