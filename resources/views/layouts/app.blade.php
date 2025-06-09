<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Fleet Management System') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
            font-size: 13px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 240px;
            background-color: #1c2260;
            color: white;
            overflow-y: auto;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 16px 20px;
            background-color: rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
        }

        .sidebar-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 16px;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            flex: 1;
            padding: 8px 0;
        }

        .menu-section {
            margin-bottom: 12px;
        }

        .menu-section-title {
            color: rgba(255,255,255,0.5);
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 20px 4px;
            margin-bottom: 2px;
        }

        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 8px 20px;
            margin: 1px 12px;
            border-radius: 6px;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 13px;
            font-weight: 500;
        }

        .sidebar-menu .nav-link:hover {
            background-color: rgba(255,255,255,0.08);
            color: #ffffff;
        }

        .sidebar-menu .nav-link.active {
            background-color: rgba(255,255,255,0.12);
            color: #ffffff;
        }

        .sidebar-menu .nav-link i {
            margin-right: 12px;
            width: 14px;
            text-align: center;
            font-size: 14px;
        }

        .sidebar-bottom {
            flex-shrink: 0;
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
            background-color: rgba(0,0,0,0.05);
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 8px 4px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background-color: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .user-avatar i {
            font-size: 14px;
            color: rgba(255,255,255,0.8);
        }

        .user-details {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: 12px;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 10px;
            color: rgba(255,255,255,0.6);
            line-height: 1.2;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .logout-btn {
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            padding: 6px 4px;
            display: flex;
            align-items: center;
            font-size: 12px;
            font-weight: 500;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            border-radius: 4px;
        }

        .logout-btn:hover {
            color: #ffffff;
            background-color: rgba(255,255,255,0.05);
        }

        .logout-btn i {
            margin-right: 8px;
            font-size: 12px;
        }

        .main-content {
            margin-left: 240px;
            min-height: 100vh;
            padding: 24px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 16px;
            }

            .mobile-toggle {
                display: block !important;
                position: fixed;
                top: 16px;
                left: 16px;
                z-index: 1001;
                background: #1c2260;
                color: white;
                border: none;
                padding: 8px 10px;
                border-radius: 6px;
                font-size: 14px;
            }
        }

        .mobile-toggle {
            display: none;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        @media (max-width: 768px) {
            .sidebar-overlay.show {
                display: block;
            }
        }

        /* Custom scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 2px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>
    <button class="mobile-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="fas fa-truck me-2"></i>FLEET-MS</h4>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">MAIN</div>
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">MANAGEMENT</div>
                <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>Clients
                </a>

                <a href="{{ route('contracts.index') }}" class="nav-link {{ request()->routeIs('contracts.*') ? 'active' : '' }}">
                    <i class="fas fa-file-contract"></i>Contracts
                </a>

                <a href="{{ route('installations.index') }}" class="nav-link {{ request()->routeIs('installations.*') ? 'active' : '' }}">
                    <i class="fas fa-tools"></i>Installations
                </a>

                <a href="{{ route('service-types.index') }}" class="nav-link {{ request()->routeIs('service-types.*') ? 'active' : '' }}">
                    <i class="fas fa-cogs"></i>Services
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">FINANCE</div>
                <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i>Invoices
                </a>

                <a href="#" class="nav-link">
                    <i class="fas fa-credit-card"></i>Payments
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">ANALYTICS</div>
                <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>Reports
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">SYSTEM</div>
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i>Users
                </a>

                {{-- Re-added Settings Link --}}
                <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>Settings
                </a>
            </div>
        </nav>

        <div class="sidebar-bottom">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-details">
                    <div class="user-name">{{ auth()->check() ? auth()->user()->name : 'Guest User' }}</div>
                    <div class="user-role">{{ auth()->check() ? ucfirst(auth()->user()->role) : 'N/A' }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');

            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        // Close sidebar when clicking on overlay
        document.querySelector('.sidebar-overlay').addEventListener('click', function() {
            toggleSidebar();
        });

        // Close sidebar on mobile when clicking a link
        document.querySelectorAll('.sidebar-menu .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    setTimeout(() => {
                        toggleSidebar();
                    }, 200);
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
