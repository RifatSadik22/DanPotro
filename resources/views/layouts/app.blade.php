<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name        /* Cards and Content */
        .card {
            background-color: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 2px 4px var(--shadow-color);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .card:hover {
            background-color: var(--card-hover);
            box-shadow: 0 4px 6px var(--shadow-color);
        }

        .card-header {
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .card-title {
            color: var(--heading-color);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .card-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        /* Campaign Stats */
        .stat-value {
            color: var(--text-color);
            font-size: 1.5rem;
            font-weight: 600;
        }

        .stat-label {
            color: var(--stats-text);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Content Text */
        .text-primary {
            color: var(--text-color);
        }

        .text-secondary {
            color: var(--text-secondary);
        }

        .text-muted {
            color: var(--text-muted);
        }

        .text-light {
            color: var(--text-light);
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            border: 1px solid transparent;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border-color: var(--success-color);
            color: var(--success-color);
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: var(--error-color);
            color: var(--error-color);
        }

        /* Theme Toggle Button */
        .theme-toggle {
            background: none;
            border: 2px solid var(--text-color);
            color: var(--text-color);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 1rem;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            opacity: 0.8;
        }ontent="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DanPotro')</title>
    <script>
        // Check for saved theme preference, otherwise use system preference
        const getTheme = () => {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                return savedTheme;
            }
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        };

        // Apply theme immediately to prevent flash
        document.documentElement.setAttribute('data-theme', getTheme());
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root[data-theme="light"] {
            --bg-color: #f8fafc;
            --text-color: #333;
            --text-muted: #666;
            --text-light: #fff;
            --text-secondary: #4b5563;
            --text-placeholder: #9ca3af;
            --card-bg: #ffffff;
            --card-hover: #f8fafc;
            --header-bg: linear-gradient(135deg, #87CEEB, #5F9EA0);
            --border-color: #e2e8f0;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --link-color: #3b82f6;
            --link-hover: #1d4ed8;
            --heading-color: #111;
            --label-color: #374151;
            --button-bg: #3b82f6;
            --button-hover: #1d4ed8;
            --button-text: #ffffff;
            --success-color: #10b981;
            --error-color: #ef4444;
            --nav-text: #ffffff;
            --stats-text: #666;
            --form-bg: #ffffff;
            --form-focus: #f8fafc;
        }

        :root[data-theme="dark"] {
            --bg-color: #111827;
            --text-color: #000080;           /* Changed to navy blue */
            --text-muted: #000066;          /* Dark blue for muted text */
            --text-light: #000099;          /* Slightly lighter blue */
            --text-secondary: #000080;      /* Navy blue for secondary text */
            --text-placeholder: #000066;    /* Dark blue for placeholders */
            --card-bg: #1f2937;
            --card-hover: #2d3748;
            --header-bg: linear-gradient(135deg, #1f2937, #111827);
            --border-color: #374151;
            --shadow-color: rgba(0, 0, 0, 0.5);
            --link-color: #000099;          /* Slightly lighter blue for links */
            --link-hover: #0000cc;          /* Brighter blue for link hover */
            --heading-color: #000080;       /* Navy blue for headings */
            --label-color: #000080;         /* Navy blue for labels */
            --button-bg: #3b82f6;
            --button-hover: #60a5fa;
            --button-text: #ffffff;         /* Keeping button text white for contrast */
            --success-color: #34d399;
            --error-color: #f87171;
            --nav-text: #ffffff;            /* Keeping nav text white for contrast */
            --stats-text: #000080;          /* Navy blue for stats */
            --form-bg: #374151;
            --form-focus: #4b5563;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            transition: all 0.3s ease;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            color: var(--heading-color);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        p {
            color: var(--text-color);
            margin-bottom: 1rem;
        }

        a {
            color: var(--link-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: var(--link-hover);
            text-decoration: underline;
        }

        .text-muted {
            color: var(--text-muted);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header & Navigation */
        .header {
            background: var(--header-bg);
            color: var(--nav-text);
            padding: 1rem 0;
            box-shadow: 0 2px 10px var(--shadow-color);
            transition: all 0.3s ease;
        }

        .nav-menu a {
            color: var(--nav-text);
            opacity: 0.9;
            transition: opacity 0.2s ease;
        }

        .nav-menu a:hover {
            opacity: 1;
            text-decoration: none;
        }

        /* Footer */
        .footer {
            background-color: var(--card-bg);
            color: var(--text-secondary);
            padding: 2rem 0;
            border-top: 1px solid var(--border-color);
        }

        .footer p {
            color: var(--text-muted);
        }

        .footer a {
            color: var(--link-color);
        }

        .footer a:hover {
            color: var(--link-hover);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-menu a:hover {
            background-color: rgba(255,255,255,0.2);
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 140px);
            padding: 2rem 0;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .card-header {
            border-bottom: 2px solid #87CEEB;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .btn-primary {
            background-color: #87CEEB;
            color: white;
        }

        .btn-primary:hover {
            background-color: #5F9EA0;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #87CEEB;
            box-shadow: 0 0 0 3px rgba(135, 206, 235, 0.1);
        }

        .form-error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Grid */
        .grid {
            display: grid;
            gap: 2rem;
        }

        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        /* Campaign Cards */
        .campaign-card {
            background: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 4px 6px var(--shadow-color);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .campaign-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px var(--shadow-color);
        }

        .campaign-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .campaign-content {
            padding: 1.5rem;
        }

        .campaign-title {
            font-size: 1.25rem;
            color: var(--heading-color);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .campaign-description {
            color: var(--text-secondary);
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
            background-color: var(--border-color);
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #87CEEB, #5F9EA0);
            transition: width 0.3s ease;
        }

        /* Footer */
        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-menu {
                flex-direction: column;
                gap: 0.5rem;
            }

            .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
            }
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 1.5rem; }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mt-3 { margin-top: 1.5rem; }
        .p-1 { padding: 0.5rem; }
        .p-2 { padding: 1rem; }
        .p-3 { padding: 1.5rem; }

        /* Donor Badge Styles */
        .donor-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            gap: 0.5rem;
        }

        .donor-badge-gold {
            background-color: rgba(255, 215, 0, 0.2);
            color: #B8860B;
            border: 1px solid #FFD700;
        }

        .donor-badge-silver {
            background-color: rgba(192, 192, 192, 0.2);
            color: #707070;
            border: 1px solid #C0C0C0;
        }

        .donor-badge-bronze {
            background-color: rgba(205, 127, 50, 0.2);
            color: #8B4513;
            border: 1px solid #CD7F32;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .table th {
            background-color: var(--card-bg);
            font-weight: 600;
            color: var(--heading-color);
        }

        .table tbody tr:hover {
            background-color: var(--card-hover);
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Badge Styles */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }

        .badge-success {
            background-color: var(--success-color);
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-danger {
            background-color: var(--error-color);
            color: white;
        }

        /* Flex utilities */
        .flex {
            display: flex;
        }

        .flex-1 {
            flex: 1;
        }

        .gap-4 {
            gap: 1rem;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        /* Font weight utilities */
        .font-weight-bold {
            font-weight: 600;
        }

        /* Background utilities */
        .bg-light {
            background-color: #f8f9fa;
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 1rem 0;
        }

        .pagination li {
            margin: 0 0.25rem;
        }

        .pagination a,
        .pagination span {
            display: block;
            padding: 0.5rem 0.75rem;
            text-decoration: none;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--link-color);
        }

        .pagination a:hover {
            background-color: var(--card-hover);
        }

        .pagination .active span {
            background-color: var(--button-bg);
            color: var(--button-text);
            border-color: var(--button-bg);
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="logo">DanPotro</a>
                <nav>
                    <ul class="nav-menu">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('campaigns.index') }}">Campaigns</a></li>
                        <li><a href="{{ route('leaderboard') }}">Leaderboard</a></li>
                        @auth
                            <li><a href="{{ route('campaigns.saved') }}">Saved Campaigns</a></li>
                            <li><a href="{{ route('donations.history') }}">My Donations</a></li>
                            @if(auth()->user()->isAdmin())
                                <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                            @else
                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; color: white; cursor: pointer; padding: 0.5rem 1rem; border-radius: 5px;">Logout</button>
                                </form>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endauth
                        <li>
                            <button class="theme-toggle" onclick="toggleTheme()">
                                <span id="theme-icon">🌞</span>
                                <span id="theme-text">Light</span>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Update button text and icon
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            if (newTheme === 'dark') {
                themeIcon.textContent = '🌙';
                themeText.textContent = 'Dark';
            } else {
                themeIcon.textContent = '🌞';
                themeText.textContent = 'Light';
            }
        }

        // Set initial button state
        window.addEventListener('DOMContentLoaded', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            if (currentTheme === 'dark') {
                themeIcon.textContent = '🌙';
                themeText.textContent = 'Dark';
            }
        });
    </script>

    <main class="main-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} DanPotro. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>