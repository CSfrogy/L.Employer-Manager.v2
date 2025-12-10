

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>L.Employee- @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="{{ asset('main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .logo-text {
            padding: 10px 0;
        }

        .logo-link {
            text-decoration: none;
            color: inherit;
        }

        .logo-modern {
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .logo-link:hover .logo-modern {
            transform: translateY(-1px);
        }

        .logo-badge-modern {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 16px;
            font-weight: 700;
            position: relative;
            overflow: hidden;
            border: 2px solid #ecf0f1;
        }

        .logo-badge-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .logo-link:hover .logo-badge-modern::before {
            transform: translateX(100%);
        }

        .logo-text-modern {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .logo-brand {
            font-size: 18px;
            font-weight: 800;
            color: #2c3e50;
            letter-spacing: -0.5px;
        }

        .logo-tagline {
            font-size: 10px;
            font-weight: 600;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-top: 1px;
        }

        .header-quick-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 30px;
            padding: 0 15px;
        }

        .quick-action-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
            border: 2px solid transparent;
            position: relative;
        }

        .quick-action-btn:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
        }

        .quick-action-btn i {
            font-size: 16px;
        }

        .quick-action-btn.tasks {
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            cursor: pointer;
            border: 2px solid #ff6b35;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .quick-action-btn.tasks:hover {
            background: linear-gradient(135deg, #f7931e 0%, #ff6b35 100%);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.5);
            transform: translateY(-1px);
        }

        .quick-action-btn.tasks span {
            font-size: 16px;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .quick-action-btn.tasks i {
            font-size: 16px;
            width: 18px;
            text-align: center;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .quick-action-btn.profile {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            cursor: pointer;
            border: 2px solid #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .quick-action-btn.profile:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            transform: translateY(-1px);
        }

        .quick-action-btn.profile span {
            font-size: 16px;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .quick-action-btn.profile i {
            font-size: 16px;
            width: 18px;
            text-align: center;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .quick-action-btn.tasks,
        .quick-action-btn.profile {
            min-width: 120px;
            height: 48px;
            justify-content: center;
            text-align: center;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 200px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            border: 1px solid #e9ecef;
            z-index: 1000;
            margin-top: 5px;
            overflow: hidden;
            animation: dropdownFadeIn 0.3s ease;
        }

        .dropdown.show .dropdown-content {
            display: block;
        }

        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: #495057;
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 1px solid #f8f9fa;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #007bff;
            padding-left: 20px;
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
            font-size: 14px;
        }

        .dropdown-item.active {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
        }

        .dropdown-item.active:hover {
            color: white;
        }

        .dropdown-toggle {
            border: none;
            background: transparent;
            color: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0;
            font-size: inherit;
            font-weight: inherit;
        }

        .dropdown-arrow {
            transition: transform 0.3s ease;
            font-size: 12px;
        }

        .dropdown.show .dropdown-arrow {
            transform: rotate(180deg);
        }

        .header-actions-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex: 1;
        }

        .logout-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 25px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .user-profile:hover {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
            line-height: 1.2;
        }

        .user-role {
            font-size: 12px;
            color: #7f8c8d;
            font-weight: 500;
        }

        .logout-btn {
            background: linear-gradient(135deg, #4c75cc 0%, #110f33 100%);
            border: none;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
            background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
        }

        .logout-btn:active {
            transform: translateY(0);
        }

        .logout-btn i {
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .user-info {
                display: none;
            }

            .logout-btn span {
                display: none;
            }

            .logout-btn {
                padding: 10px;
            }

            .header-quick-actions {
                display: none;
            }
        }

        @media (max-width: 992px) {
            .header-quick-actions .quick-action-btn span {
                display: none;
            }

            .header-quick-actions .quick-action-btn {
                padding: 12px;
            }

            .dropdown-content {
                min-width: 160px;
            }
        }

        .sidebar-nav-item {
            display: block;
            padding: 15px 20px;
            color: #495057;
            text-decoration: none;
            border-radius: 12px;
            margin: 4px 12px;
            transition: all 0.3s ease;
            position: relative;
            font-weight: 500;
            border: 2px solid transparent;
        }

        .sidebar-nav-item:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #007bff;
            transform: translateX(8px);
            border-color: rgba(0, 123, 255, 0.2);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
        }

        .sidebar-nav-item.active {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateX(8px);
        }

        .sidebar-nav-item i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-nav-section {
            margin-bottom: 30px;
        }

        .sidebar-nav-title {
            padding: 12px 20px 8px 20px;
            font-size: 12px;
            font-weight: 700;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 20px;
            border-bottom: 2px solid #e9ecef;
            position: relative;
        }

        .sidebar-nav-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 20px;
            width: 40px;
            height: 2px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .sidebar-submenu {
            padding-left: 10px;
            margin-top: 5px;
        }

        .sidebar-submenu .sidebar-nav-item {
            padding: 12px 18px;
            font-size: 14px;
            margin: 2px 8px;
            background: rgba(0, 123, 255, 0.05);
            border-radius: 8px;
        }

        .sidebar-submenu .sidebar-nav-item i {
            margin-right: 10px;
            width: 18px;
            font-size: 14px;
        }

        .sidebar-submenu .sidebar-nav-item:hover {
            background: rgba(0, 123, 255, 0.1);
        }

        .role-badge {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .role-badge.admin {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .role-badge.employee {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        }

        .app-main {
            margin-left: 0 !important;
            width: 100% !important;
        }

        .app-main__outer {
            margin-left: 0 !important;
            width: 100% !important;
        }

        .app-main__inner {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            padding-left: 20px !important;
            padding-right: 20px !important;
        }

        .app-container.app-theme-white {
            margin-left: 0 !important;
        }


        .app-container.app-theme-white.body-tabs-shadow.fixed-sidebar.fixed-header {
            margin-left: 0 !important;
        }

        .scrollbar-sidebar {
            display: none !important;
        }


        .mobile-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            border-top: 2px solid rgba(255, 255, 255, 0.1);
            padding: 8px 0;
            z-index: 1000;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }

        .mobile-nav-list {
            display: flex;
            justify-content: space-around;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0 10px;
        }

        .mobile-nav-item {
            flex: 1;
            text-align: center;
        }

        .mobile-nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.7);
            padding: 8px 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            min-height: 56px;
            justify-content: center;
            gap: 4px;
        }

        .mobile-nav-link:hover {
            color: rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .mobile-nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        .mobile-nav-link i {
            font-size: 20px;
            position: relative;
        }

        .mobile-nav-text {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .mobile-nav-badge {
            position: absolute;
            top: -2px;
            right: -8px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: 700;
            min-width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.4);
            border: 2px solid #2c3e50;
        }

        .mobile-nav-badge.hidden {
            display: none;
        }


        .mobile-nav-padding {
            display: none;
            height: 70px;
        }


        @media (max-width: 768px) {
            .mobile-nav,
            .mobile-nav-padding {
                display: block;
            }

            .app-main {
                padding-bottom: 80px;
            }


            .header-actions-container {
                display: none;
            }

            .user-info {
                display: none;
            }
        }


        @media (max-width: 576px) {
            .mobile-nav-link {
                padding: 6px 8px;
                min-height: 52px;
            }

            .mobile-nav-link i {
                font-size: 18px;
            }

            .mobile-nav-text {
                font-size: 10px;
            }

            .app-main {
                padding-bottom: 75px;
            }
        }


        @keyframes navItemActive {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .mobile-nav-link.active {
            animation: navItemActive 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-text">
                    <a href="{{ $userRole === 'admin' ? route('admin.dashboard') : route('employee.dashboard') }}" class="logo-link">
                        <div class="logo-modern">
                            <div class="logo-badge-modern">
                                EM
                            </div>
                            <div class="logo-text-modern">
                                <span class="logo-brand">L.Employee</span>
                                <span class="logo-tagline">{{ $userRole === 'admin' ? 'Complete your duty!' : 'Employee Portal' }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="app-header__content">
                <div class="app-header-left">
                    <div class="header-actions-container">
                        @if($userRole === 'employee')
                            <div class="header-quick-actions">
                                <div class="dropdown">
                                    <div class="quick-action-btn tasks dropdown-toggle" id="tasksDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-tasks"></i>
                                        <span>My Tasks</span>
                                    </div>
                                    <div class="dropdown-content" aria-labelledby="tasksDropdown">
                                        <a href="{{ route('employee.tasks.index') }}" class="dropdown-item {{ Request::route()->getName() == 'employee.tasks.index' && !Request('status') ? 'active' : '' }}">
                                            <i class="fas fa-list"></i>
                                            <span>All Tasks</span>
                                        </a>
                                        <a href="{{ route('employee.tasks.index', ['status' => '1']) }}" class="dropdown-item {{ Request::route()->getName() == 'employee.tasks.index' && Request('status') == '1' ? 'active' : '' }}">
                                            <i class="fas fa-play"></i>
                                            <span>Active Tasks</span>
                                        </a>
                                        <a href="{{ route('employee.tasks.index', ['status' => '2']) }}" class="dropdown-item {{ Request::route()->getName() == 'employee.tasks.index' && Request('status') == '2' ? 'active' : '' }}">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Completed Tasks</span>
                                        </a>
                                    </div>
                                </div>
                                <a href="{{ route('employee.profile.index') }}" class="quick-action-btn profile" title="Profile Settings">
                                    <i class="fas fa-user-cog"></i>
                                    <span>Profile</span>
                                </a>
                                <a href="{{ route('employee.messages.index') }}" class="quick-action-btn messages" title="Messages">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Messages</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="logout-container">
                                    <div class="user-profile">
                                        <div class="user-avatar">
                                            @if($userRole === 'admin')
                                                <i class="fas fa-user-shield"></i>
                                            @else
                                                @if($user && $user->image)
                                                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}">
                                                @else
                                                    <i class="fas fa-user-tie"></i>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="user-info">
                                            <div class="user-name">
                                                {{ $userRole === 'admin' ? 'Administrator' : ($user->name ?? 'User') }}
                                            </div>
                                        </div>
                                    </div>
                                    <form id="logout-form" action="{{ $userRole === 'admin' ? route('admin.logout') : route('employee.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <button type="button" class="logout-btn"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-main">
            @yield('content')
            <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        </div>


        <div class="mobile-nav-padding"></div>
        <nav class="mobile-nav">
            <ul class="mobile-nav-list">
                <li class="mobile-nav-item">
                    <a href="{{ route('employee.dashboard') }}" 
                       class="mobile-nav-link {{ Request::route()->getName() == 'employee.dashboard' ? 'active' : '' }}" 
                       data-nav="dashboard">
                        <i class="fas fa-home"></i>
                        <span class="mobile-nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="mobile-nav-item">
                    <a href="{{ route('employee.tasks.index') }}" 
                       class="mobile-nav-link {{ Request::route()->getName() == 'employee.tasks.index' || Request::route()->getName() == 'employee.tasks.show' ? 'active' : '' }}" 
                       data-nav="tasks">
                        <i class="fas fa-tasks"></i>
                        <span class="mobile-nav-text">Tasks</span>
                        @if($userRole === 'employee' && isset($taskStats) && $taskStats['active_tasks'] > 0)
                            <span class="mobile-nav-badge" id="tasks-badge">{{ $taskStats['active_tasks'] }}</span>
                        @else
                            <span class="mobile-nav-badge hidden" id="tasks-badge">0</span>
                        @endif
                    </a>
                </li>
                <li class="mobile-nav-item">
                    <a href="{{ route('employee.messages.index') }}" 
                       class="mobile-nav-link {{ Request::route()->getName() == 'employee.messages.index' || Request::route()->getName() == 'employee.messages.show' || Request::route()->getName() == 'employee.messages.create' ? 'active' : '' }}" 
                       data-nav="messages">
                        <i class="fas fa-paper-plane"></i>
                        <span class="mobile-nav-text">Messages</span>
                        @if($userRole === 'employee' && isset($unreadMessages) && $unreadMessages > 0)
                            <span class="mobile-nav-badge" id="messages-badge">{{ $unreadMessages }}</span>
                        @else
                            <span class="mobile-nav-badge hidden" id="messages-badge">0</span>
                        @endif
                    </a>
                </li>
                <li class="mobile-nav-item">
                    @if($userRole === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="mobile-nav-link {{ Request::route()->getName() == 'admin.dashboard' ? 'active' : '' }}"
                           data-nav="dashboard">
                            <i class="fas fa-home"></i>
                            <span class="mobile-nav-text">Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('employee.profile.index') }}"
                           class="mobile-nav-link {{ Request::route()->getName() == 'employee.profile.index' ? 'active' : '' }}"
                           data-nav="profile">
                            <i class="fas fa-user"></i>
                            <span class="mobile-nav-text">Profile</span>
                        </a>
                    @endif
                </li>
                <li class="mobile-nav-item">
                    <button class="mobile-nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-nav="logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="mobile-nav-text">Logout</span>
                    </button>
                </li>
            </ul>
        </nav>
    </div>
    <script type="text/javascript" src="{{ asset('assets/scripts/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/scripts/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        $(document).ready(function() {

            $('.dropdown-toggle').click(function(e) {
                e.preventDefault();
                e.stopPropagation();

                const dropdown = $(this).closest('.dropdown');
                const isOpen = dropdown.hasClass('show');


                $('.dropdown').removeClass('show');

                if (!isOpen) {
                    dropdown.addClass('show');
                }
            });


            $(document).click(function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown').removeClass('show');
                }
            });


            $(document).keyup(function(e) {

                if (e.keyCode === 27) {
                    $('.dropdown').removeClass('show');
                }
            });


            $('.mobile-nav-link').click(function(e) {
                $('.mobile-nav-link').removeClass('active');
                $(this).addClass('active');

                if ('vibrate' in navigator) {
                    navigator.vibrate(50);
                }

                updateNavigationBadges();
            });

            // Handle logout button click
            $('.mobile-nav-link[data-nav="logout"]').click(function(e) {
                e.preventDefault();
                $(this).addClass('active');
                if ('vibrate' in navigator) {
                    navigator.vibrate(50);
                }
                setTimeout(function() {
                    document.getElementById('logout-form').submit();
                }, 100);
            });


            function updateNavigationBadges() {
                const tasksBadge = $('#tasks-badge');
                const messagesBadge = $('#messages-badge');
                
                if (tasksBadge.length && parseInt(tasksBadge.text()) > 0) {
                    tasksBadge.removeClass('hidden');
                } else if (tasksBadge.length) {
                    tasksBadge.addClass('hidden');
                }
                
                if (messagesBadge.length && parseInt(messagesBadge.text()) > 0) {
                    messagesBadge.removeClass('hidden');
                } else if (messagesBadge.length) {
                    messagesBadge.addClass('hidden');
                }
            }

            updateNavigationBadges();

            $(window).on('orientationchange', function() {
                setTimeout(function() {
                    updateNavigationBadges();
                }, 500);
            });

            $('.mobile-nav-link').on('click', function() {
                const href = $(this).attr('href');
                if (href && href.startsWith('#')) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: $(href).offset().top - 100
                    }, 300);
                }
            });

            $('.mobile-nav-link').on('keydown', function(e) {

                if (e.keyCode === 13 || e.keyCode === 32) {
                    e.preventDefault();
                    $(this).click();
                }
            });

            let touchStartX = 0;
            let touchEndX = 0;
            
            $('.mobile-nav').on('touchstart', function(e) {
                touchStartX = e.originalEvent.changedTouches[0].screenX;
            });
            
            $('.mobile-nav').on('touchend', function(e) {
                touchEndX = e.originalEvent.changedTouches[0].screenX;
                handleSwipeGesture();
            });
            
            function handleSwipeGesture() {
                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;
                
                if (Math.abs(diff) > swipeThreshold) {
                    $('.mobile-nav').addClass('swipe-animation');
                    setTimeout(function() {
                        $('.mobile-nav').removeClass('swipe-animation');
                    }, 300);
                }
            }

            $('<style>')
                .prop('type', 'text/css')
                .html(`
                    .mobile-nav.swipe-animation {
                        transform: translateX(5px);
                        transition: transform 0.1s ease;
                    }
                `)
                .appendTo('head');
        });
    </script>

    @yield('footer')
</body>

</html>
