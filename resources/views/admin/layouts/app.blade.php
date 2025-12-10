<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>L.Employer- @yield('title')</title>
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

        /* Mobile responsive */
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
        }
    </style>
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-text">
                    <a href="{{ route('admin.dashboard') }}" class="logo-link">
                        <div class="logo-modern">
                            <div class="logo-badge-modern">
                                EM
                            </div>
                            <div class="logo-text-modern">
                                <span class="logo-brand">L.Employer</span>
                                <span class="logo-tagline">Complete your duty!</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                            data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__content">
                <div class="app-header-left">
                </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="logout-container">
                                    <div class="user-profile">
                                        <div class="user-avatar">
                                            <i class="fas fa-user-shield"></i>
                                        </div>
                                        <div class="user-info">
                                            <div class="user-name">Administrator</div>
                                            <div class="user-role">System Admin</div>
                                        </div>
                                    </div>
                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
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
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button"
                            class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">Workspace</li>
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="mm-active">
                                    <i class="metismenu-icon pe-7s-browser"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-user"></i>
                                    Employee
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul class="mm-collapse">
                                    <li>
                                        <a href="{{ route('admin.employee.list') }}" class="mm-active">
                                            <i class="metismenu-icon pe-7s-rocket"></i>
                                            List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.employee.add') }}" class="mm-active">
                                            <i class="metismenu-icon pe-7s-rocket"></i>
                                            Add New
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-check"></i>
                                    Task
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul class="mm-collapse">
                                    <li>
                                        <a href="{{ route('admin.task.list') }}" class="mm-active">
                                            <i class="metismenu-icon pe-7s-rocket"></i>
                                            List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.task.add') }}" class="mm-active">
                                            <i class="metismenu-icon pe-7s-rocket"></i>
                                            Create New
                                        </a>
                                    </li>
                                </ul>
                            </li>
                             <li>
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-config"></i>
                                    Admin
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul class="mm-collapse">
                                    <li>
                                        <a href="{{ route('admin.admin.list') }}" class="mm-active">
                                            <i class="metismenu-icon pe-7s-rocket"></i>
                                            List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.admin.add') }}" class="mm-active">
                                            <i class="metismenu-icon pe-7s-rocket"></i>
                                            Add New
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{ route('admin.mailbox.index') }}">
                                    <i class="metismenu-icon pe-7s-mail"></i>
                                    Mailbox
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @yield('content')
            <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('assets/scripts/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/scripts/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    @yield('footer')
</body>

</html>
