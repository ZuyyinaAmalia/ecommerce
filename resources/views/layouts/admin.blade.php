<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title','Admin Dashboard')</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-dark: #4b2e05;
            --primary-light: #6a4714;
            --background: #f5e9d3;
            --card-bg: #fff9f1;
            --border: #e3d4b4;
            --accent-border: #7b5b2e;
            --text-light: #f5e9d3;
            --text-muted: #d9c9a1;
            --success: #10b981;
            --error: #ef4444;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: var(--background);
            font-family: 'Georgia', serif;
            min-height: 100vh;
        }
        
        .app-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* SIDEBAR STYLING */
        .sidebar {
            background-color: var(--primary-dark);
            color: var(--text-light);
            width: 280px;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            height: 100vh;
            z-index: 100;
        }
        
        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 24px 20px;
            border-bottom: 1px solid var(--accent-border);
        }
        
        .logo-container {
            background-color: var(--text-light);
            color: var(--primary-dark);
            border-radius: 12px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.5rem;
            box-shadow: var(--shadow);
        }
        
        .brand-text h1 {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .brand-text p {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 4px;
        }
        
        .sidebar-nav {
            flex: 1;
            padding: 20px 16px;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 8px;
            text-decoration: none;
            color: var(--text-light);
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .nav-item:hover {
            background-color: var(--primary-light);
            transform: translateX(5px);
        }
        
        .nav-item.active {
            background-color: var(--primary-light);
            position: relative;
            font-weight: 600;
        }
        
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--text-light);
            border-radius: 0 4px 4px 0;
        }
        
        .nav-icon {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }
        
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--accent-border);
            text-align: center;
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        
        /* MAIN CONTENT STYLING */
        .main-content {
            flex: 1;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .header {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border);
            padding: 18px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-greeting {
            font-size: 0.95rem;
            color: #555;
        }
        
        .logout-btn {
            background-color: var(--primary-dark);
            color: var(--text-light);
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .logout-btn:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        
        .content-area {
            flex: 1;
            padding: 24px 32px;
            overflow-y: auto;
        }
        
        /* NOTIFICATION STYLING */
        .notification {
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease-out;
            transition: opacity 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .notification-success {
            border-left: 4px solid var(--success);
            background-color: rgba(16, 185, 129, 0.1);
            color: #065f46;
        }

        .notification-error {
            border-left: 4px solid var(--error);
            background-color: rgba(239, 68, 68, 0.1);
            color: #7f1d1d;
        }
        
        .notification-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .notification-success .notification-icon {
            color: var(--success);
        }

        .notification-error .notification-icon {
            color: var(--error);
        }

        .notification-close {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            opacity: 0.5;
            transition: opacity 0.2s;
        }

        .notification-close:hover {
            opacity: 1;
        }
        
        /* CARD STYLING */
        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 24px;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 24px;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.08);
        }
        
        .card-header {
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }
        
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-container">
                    🪶
                </div>
                <div class="brand-text">
                    <h1>Batik Mania</h1>
                    <p>Admin Panel</p>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-item" data-page="dashboard">
                    <span class="nav-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('orders.index') }}" class="nav-item" data-page="orders">
                    <span class="nav-icon">🧾</span>
                    <span>Pesanan</span>
                </a>
                <a href="{{ route('details.index') }}" class="nav-item" data-page="details">
                    <span class="nav-icon">📋</span>
                    <span>Detail Pesanan</span>
                </a>
                <a href="{{ route('categories.index') }}" class="nav-item" data-page="categories">
                    <span class="nav-icon">🏷️</span>
                    <span>Kategori</span>
                </a>
                <a href="{{ route('products.index') }}" class="nav-item" data-page="products">
                    <span class="nav-icon">📦</span>
                    <span>Produk</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                © {{ date('Y') }} Batik Mania
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- HEADER -->
            <header class="header">
                <h1 class="page-title">@yield('page-title','Overview')</h1>
                <div class="user-info">
                    <span class="user-greeting">
                        Hi, {{ Auth::user()->name ?? 'Guest' }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </header>

            <!-- CONTENT AREA -->
            <main class="content-area">
                {{-- SUCCESS NOTIFICATION --}}
                @if(session('success'))
                    <div class="notification notification-success" id="notification-success">
                        <svg class="notification-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                        <button class="notification-close" onclick="closeNotification('notification-success')">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- ERROR NOTIFICATION --}}
                @if(session('error'))
                    <div class="notification notification-error" id="notification-error">
                        <svg class="notification-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                        <button class="notification-close" onclick="closeNotification('notification-error')">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                <div class="content-wrapper">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        // Close notification manually
        function closeNotification(id) {
            const notification = document.getElementById(id);
            if (notification) {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }
        }

        // Auto-hide notification after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = document.querySelectorAll('.notification');
            
            notifications.forEach(notification => {
                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }, 5000); // 5 seconds
            });
        });

        // Active menu highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.nav-item');
            
            menuItems.forEach(item => {
                item.classList.remove('active');
                
                const itemPath = item.getAttribute('href');
                const dataPage = item.getAttribute('data-page');
                
                // Check if current path contains the data-page value
                if (currentPath.includes(dataPage) || currentPath === itemPath) {
                    item.classList.add('active');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>

