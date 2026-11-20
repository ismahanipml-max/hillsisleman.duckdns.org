<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') · DPC HILLSI Sleman</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-hillsi.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg: #f2f8f9;
            --surface: #ffffff;
            --surface-card: #ffffff;
            --text: #12262d;
            --text-muted: #537078;
            --border: #d2e4e7;
            --border-subtle: #e4f1f3;
            --sidebar-bg: #213A58; /* Color #6 dari palet: Deep Navy */
            --sidebar-surface: #182e47;
            --sidebar-text: #e6f8f7;
            --sidebar-muted: #8eb1c2;
            --sidebar-active: #0C6478; /* Color #5 dari palet: Dark Teal */
            --sidebar-border: rgba(255, 255, 255, 0.08);
            --brand: #0C6478; /* Color #5 dari palet */
            --brand-light: #15919B; /* Color #4 dari palet: Medium Teal */
            --brand-cyan: #09D1C7; /* Color #3 dari palet: Cyan Aqua */
            --accent: #46DFB1; /* Color #2 dari palet: Mint Turquoise */
            --mint: #80EE98; /* Color #1 dari palet: Spring Mint */
            --brand-glow: rgba(9, 209, 199, 0.25);
            --success: #10b981;
            --danger: #ef4444;
            --shadow-sm: 0 2px 8px rgba(33, 58, 88, 0.06);
            --shadow-md: 0 8px 24px rgba(33, 58, 88, 0.1);
            --shadow-lg: 0 16px 40px rgba(33, 58, 88, 0.16);
        }

        html[data-theme="dark"] {
            --bg: #0f1c2b;
            --surface: #16283b;
            --surface-card: #1c3249;
            --text: #e6f8f7;
            --text-muted: #8eb1c2;
            --border: #244160;
            --border-subtle: #1b324b;
            --sidebar-bg: #0c1825;
            --sidebar-surface: #132437;
            --sidebar-text: #e6f8f7;
            --sidebar-muted: #7e9fae;
            --sidebar-active: #0C6478;
            --sidebar-border: rgba(255, 255, 255, 0.06);
            --brand: #09D1C7;
            --brand-light: #46DFB1;
            --brand-cyan: #09D1C7;
            --accent: #80EE98;
            --mint: #80EE98;
            --brand-glow: rgba(70, 223, 177, 0.25);
            --success: #34d399;
            --danger: #f87171;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.35);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.45);
            --shadow-lg: 0 16px 40px rgba(0, 0, 0, 0.55);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            transition: background-color 0.25s, color 0.25s;
        }

        /* Sidebar */
        aside.sidebar {
            width: 270px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 50;
            border-right: 1px solid var(--sidebar-border);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--sidebar-border);
        }

        .sidebar-logo {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #ffffff;
            padding: 3px;
            display: grid;
            place-items: center;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
            flex-shrink: 0;
            overflow: hidden;
        }

        .sidebar-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .sidebar-brand-text h2 {
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .sidebar-brand-text span {
            font-size: 11px;
            font-weight: 600;
            color: var(--sidebar-muted);
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .sidebar-menu {
            flex: 1;
            padding: 20px 14px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .menu-heading {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--sidebar-muted);
            padding: 10px 12px 6px;
            opacity: 0.85;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.2s, color 0.2s, transform 0.15s;
        }

        .menu-link .icon {
            font-size: 18px;
            width: 24px;
            text-align: center;
            opacity: 0.85;
        }

        .menu-link:hover {
            background: var(--sidebar-surface);
            color: #46DFB1;
            transform: translateX(3px);
        }

        .menu-link.active {
            background: linear-gradient(90deg, #0C6478, #15919B);
            color: #fff;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
            border-left: 3px solid #46DFB1;
        }

        .sidebar-footer {
            padding: 18px 16px;
            border-top: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .theme-toggle-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--sidebar-surface);
            border: 1px solid var(--sidebar-border);
            color: var(--sidebar-text);
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .theme-toggle-btn:hover {
            background: color-mix(in srgb, var(--sidebar-surface) 80%, white);
        }

        .logout-form button {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #fca5a5;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .logout-form button:hover {
            background: rgba(239, 68, 68, 0.28);
            color: #fee2e2;
        }

        /* Main Content */
        .main-wrapper {
            flex: 1;
            margin-left: 270px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
        }

        /* Top Bar */
        header.admin-header {
            height: 68px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 30;
            backdrop-filter: blur(10px);
            transition: background-color 0.25s, border-color 0.25s;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            padding: 8px;
            font-size: 18px;
            cursor: pointer;
        }

        .page-title h1 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text);
            line-height: 1.2;
        }

        .page-title span {
            font-size: 12px;
            color: var(--text-muted);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-view-site {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 99px;
            background: rgba(9, 209, 199, 0.14);
            color: var(--brand);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid rgba(9, 209, 199, 0.25);
            transition: all 0.2s;
        }

        .btn-view-site:hover {
            background: linear-gradient(135deg, #0C6478, #15919B);
            color: #fff;
        }

        .content-area {
            flex: 1;
            padding: 28px;
        }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--surface-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: color-mix(in srgb, var(--brand) 12%, transparent);
            color: var(--brand);
            display: grid;
            place-items: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .stat-info h3 {
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
            line-height: 1.1;
        }

        .stat-info p {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Generic Card */
        .card-box {
            background: var(--surface-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
            transition: background-color 0.25s, border-color 0.25s;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-header h2 {
            font-size: 17px;
            font-weight: 800;
            color: var(--text);
        }

        .card-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Action Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0C6478, #15919B);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(12, 100, 120, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #15919B, #09D1C7);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(9, 209, 199, 0.4);
        }

        .btn-secondary {
            background: var(--bg);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: color-mix(in srgb, var(--bg) 80%, black);
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.12);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            background: var(--danger);
            color: #fff;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 8px;
        }

        /* iOS Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
            vertical-align: middle;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #cbd5e1;
            transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 99px;
        }

        html[data-theme="dark"] .slider {
            background-color: #334155;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        input:checked + .slider {
            background-color: var(--brand);
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        /* Table */
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        table.admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13.5px;
        }

        table.admin-table thead {
            background: color-mix(in srgb, var(--bg) 60%, var(--surface));
            border-bottom: 1px solid var(--border);
        }

        table.admin-table th {
            padding: 13px 16px;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        table.admin-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-subtle);
            color: var(--text);
            vertical-align: middle;
        }

        table.admin-table tr:last-child td {
            border-bottom: none;
        }

        table.admin-table tr:hover td {
            background: color-mix(in srgb, var(--brand) 3%, transparent);
        }

        /* Pill / Badge */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 99px;
            white-space: nowrap;
        }

        .pill-brand {
            background: color-mix(in srgb, var(--brand) 12%, transparent);
            color: var(--brand);
        }

        .pill-success {
            background: rgba(16, 185, 129, 0.12);
            color: var(--success);
        }

        .pill-danger {
            background: rgba(239, 68, 68, 0.12);
            color: var(--danger);
        }

        .pill-muted {
            background: var(--bg);
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        /* Toast */
        .toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .toast {
            pointer-events: auto;
            background: var(--surface);
            color: var(--text);
            border: 1px solid var(--border);
            padding: 14px 18px;
            border-radius: 14px;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
            font-weight: 600;
            min-width: 280px;
            max-width: 420px;
            transform: translateX(120%);
            opacity: 0;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s;
        }

        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast.success {
            border-left: 4px solid var(--brand);
        }

        .toast.error {
            border-left: 4px solid var(--danger);
        }

        .toast-icon {
            font-size: 20px;
            flex-shrink: 0;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(5px);
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.25s;
        }

        .modal-overlay.open {
            display: flex;
            opacity: 1;
        }

        .modal-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            width: 100%;
            max-width: 780px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            transform: scale(0.95);
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-overlay.open .modal-box {
            transform: scale(1);
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text);
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 22px;
            cursor: pointer;
            padding: 4px;
            border-radius: 8px;
            line-height: 1;
        }

        .modal-close:hover {
            color: var(--text);
        }

        .modal-body {
            padding: 24px;
            overflow-y: auto;
            flex: 1;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            background: color-mix(in srgb, var(--bg) 40%, var(--surface));
        }

        /* Form elements */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.col-full {
            grid-column: 1 / -1;
        }

        label.form-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        label.form-label span.req {
            color: var(--danger);
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: var(--bg);
            color: var(--text);
            font-family: inherit;
            font-size: 13.5px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px var(--brand-glow);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .form-hint {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Mobile Responsive */
        @media (max-width: 900px) {
            aside.sidebar {
                transform: translateX(-100%);
            }

            aside.sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block;
            }

            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
                z-index: 45;
                display: none;
            }

            .sidebar-backdrop.active {
                display: block;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .content-area {
                padding: 18px 14px;
            }

            header.admin-header {
                padding: 0 16px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Backdrop for mobile drawer -->
    <div id="sidebarBackdrop" class="sidebar-backdrop" onclick="toggleMobileSidebar()"></div>

    <!-- Sidebar Gelap Hijau Tosca -->
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo">
                <img src="{{ asset('images/logo-hillsi.png') }}" alt="Logo HILLSI Sleman">
            </div>
            <div class="sidebar-brand-text">
                <h2>HILLSI Sleman</h2>
                <span>Panel Administrasi</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-heading">Menu Utama</div>
            
            <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon">📊</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.lpks.index') }}" class="menu-link {{ request()->routeIs('admin.lpks.*') ? 'active' : '' }}">
                <span class="icon">🏢</span>
                <span>Data LPK</span>
            </a>

            <a href="{{ route('admin.articles.index') }}" class="menu-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <span class="icon">📰</span>
                <span>Kegiatan</span>
            </a>

            <a href="{{ route('admin.settings.edit') }}" class="menu-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <span class="icon">⚙️</span>
                <span>Pengaturan</span>
            </a>

            <div class="menu-heading" style="margin-top: 14px;">Tautan Eksternal</div>
            <a href="{{ url('/') }}" target="_blank" class="menu-link">
                <span class="icon">🌐</span>
                <span>Lihat Website</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <button type="button" class="theme-toggle-btn" onclick="toggleTheme()">
                <span id="themeToggleLabel">🌙 Mode Gelap</span>
                <span id="themeToggleIcon">✨</span>
            </button>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit">
                    <span>🚪</span>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <header class="admin-header">
            <div class="header-left">
                <button type="button" class="mobile-toggle" onclick="toggleMobileSidebar()" aria-label="Buka Menu">
                    ☰
                </button>
                <div class="page-title">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <span>@yield('page-subtitle', 'Sistem Administrasi DPC HILLSI Sleman')</span>
                </div>
            </div>

            <div class="header-right">
                <a href="{{ url('/') }}" target="_blank" class="btn-view-site">
                    <span>Lihat Website</span>
                    <span>&nearr;</span>
                </a>
            </div>
        </header>

        <main class="content-area">
            @yield('content')
        </main>
    </div>

    <!-- Toast Notifications Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Theme switcher logic
        function initTheme() {
            var saved = localStorage.getItem('hillsi_admin_theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
            updateThemeButton(saved);
        }

        function toggleTheme() {
            var current = document.documentElement.getAttribute('data-theme') || 'light';
            var next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('hillsi_admin_theme', next);
            updateThemeButton(next);
            showToast('Tema diubah ke mode ' + (next === 'dark' ? 'gelap' : 'terang') + '.', 'info');
        }

        function updateThemeButton(theme) {
            var label = document.getElementById('themeToggleLabel');
            var icon = document.getElementById('themeToggleIcon');
            if (label && icon) {
                if (theme === 'dark') {
                    label.textContent = '☀️ Mode Terang';
                    icon.textContent = '💡';
                } else {
                    label.textContent = '🌙 Mode Gelap';
                    icon.textContent = '✨';
                }
            }
        }

        // Mobile drawer
        function toggleMobileSidebar() {
            var sidebar = document.getElementById('adminSidebar');
            var backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar) sidebar.classList.toggle('mobile-open');
            if (backdrop) backdrop.classList.toggle('active');
        }

        // Toast helper
        function showToast(message, type = 'success') {
            var container = document.getElementById('toastContainer');
            if (!container) return;

            var toast = document.createElement('div');
            toast.className = 'toast ' + type;
            var icon = type === 'error' ? '❌' : (type === 'info' ? 'ℹ️' : '✅');
            toast.innerHTML = '<span class="toast-icon">' + icon + '</span><span>' + message + '</span>';

            container.appendChild(toast);
            requestAnimationFrame(function() {
                toast.classList.add('show');
            });

            setTimeout(function() {
                toast.classList.remove('show');
                setTimeout(function() {
                    if (toast.parentNode) toast.parentNode.removeChild(toast);
                }, 300);
            }, 3500);
        }

        document.addEventListener('DOMContentLoaded', function() {
            initTheme();

            @if(session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif

            @if(session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif

            @if($errors->any())
                showToast("{{ $errors->first() }}", 'error');
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>

