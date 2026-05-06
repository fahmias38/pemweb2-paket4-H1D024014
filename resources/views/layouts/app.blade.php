<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CleanPro') }} — Laundry Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        :root {
            --cp-blue: #1a6fc4;
            --cp-blue-dark: #0f4f96;
            --cp-sky: #e8f4fd;
            --cp-accent: #06b6d4;
            --cp-green: #10b981;
            --cp-orange: #f59e0b;
            --cp-red: #ef4444;
        }

        body { background: #f0f7ff; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 240px; min-height: 100vh;
            background: linear-gradient(180deg, #0f4f96 0%, #1a6fc4 40%, #0891b2 100%);
            position: fixed; top: 0; left: 0; z-index: 50;
            display: flex; flex-direction: column;
            box-shadow: 4px 0 20px rgba(15,79,150,0.3);
        }
        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }
        .sidebar-brand .logo-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; margin-bottom: 8px;
        }
        .sidebar-brand h1 { color: #fff; font-size: 18px; font-weight: 800; margin: 0; }
        .sidebar-brand p { color: rgba(255,255,255,0.6); font-size: 11px; margin: 2px 0 0; }

        .sidebar-nav { flex: 1; padding: 16px 12px; }
        .nav-section-label {
            color: rgba(255,255,255,0.45); font-size: 10px; font-weight: 700;
            letter-spacing: 1.2px; text-transform: uppercase;
            padding: 12px 8px 4px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            color: rgba(255,255,255,0.75); font-size: 13.5px; font-weight: 500;
            text-decoration: none; margin-bottom: 2px;
            transition: all 0.2s ease;
        }
        .nav-item:hover { background: rgba(255,255,255,0.12); color: #fff; }
        .nav-item.active {
            background: rgba(255,255,255,0.2); color: #fff; font-weight: 700;
            box-shadow: inset 3px 0 0 rgba(255,255,255,0.8);
        }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .user-info {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            background: rgba(255,255,255,0.1);
        }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px; color: #fff; flex-shrink: 0;
        }
        .user-name { color: #fff; font-size: 13px; font-weight: 600; }
        .user-role {
            display: inline-block; font-size: 10px; font-weight: 700;
            padding: 1px 6px; border-radius: 4px; margin-top: 1px;
            background: rgba(255,255,255,0.2); color: rgba(255,255,255,0.9);
            text-transform: uppercase; letter-spacing: 0.5px;
        }

        /* Main content */
        .main-content { margin-left: 240px; min-height: 100vh; }
        .topbar {
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #e5eeff;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px;
            box-shadow: 0 1px 8px rgba(26,111,196,0.07);
            position: sticky; top: 0; z-index: 40;
        }
        .page-title { font-size: 17px; font-weight: 700; color: #1e293b; }
        .page-title span { color: #64748b; font-weight: 400; font-size: 13px; margin-left: 8px; }

        .content-area { padding: 28px 32px; }

        /* Cards */
        .card {
            background: #fff; border-radius: 16px;
            box-shadow: 0 2px 12px rgba(26,111,196,0.07);
            border: 1px solid #e8f0ff;
        }
        .card-header {
            padding: 18px 24px; border-bottom: 1px solid #f1f5ff;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-title { font-size: 15px; font-weight: 700; color: #1e293b; }
        .card-body { padding: 24px; }

        /* Stat cards */
        .stat-card {
            border-radius: 16px; padding: 20px;
            display: flex; align-items: center; gap: 16px;
        }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; flex-shrink: 0;
        }
        .stat-value { font-size: 24px; font-weight: 800; color: #1e293b; }
        .stat-label { font-size: 12px; color: #64748b; font-weight: 500; margin-top: 2px; }

        /* Buttons */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, #1a6fc4, #0891b2);
            color: #fff; font-weight: 600; font-size: 13px;
            padding: 9px 18px; border-radius: 10px; border: none;
            cursor: pointer; text-decoration: none;
            transition: all 0.2s; box-shadow: 0 2px 8px rgba(26,111,196,0.3);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(26,111,196,0.4); color: #fff; }

        .btn-secondary {
            display: inline-flex; align-items: center; gap: 6px;
            background: #f1f5f9; color: #475569; font-weight: 600; font-size: 13px;
            padding: 9px 18px; border-radius: 10px; border: 1px solid #e2e8f0;
            cursor: pointer; text-decoration: none; transition: all 0.2s;
        }
        .btn-secondary:hover { background: #e2e8f0; color: #334155; }

        .btn-danger {
            display: inline-flex; align-items: center; gap: 6px;
            background: #fef2f2; color: #dc2626; font-weight: 600; font-size: 13px;
            padding: 9px 18px; border-radius: 10px; border: 1px solid #fecaca;
            cursor: pointer; text-decoration: none; transition: all 0.2s;
        }
        .btn-danger:hover { background: #fee2e2; }

        .btn-success {
            display: inline-flex; align-items: center; gap: 6px;
            background: #f0fdf4; color: #16a34a; font-weight: 600; font-size: 13px;
            padding: 9px 18px; border-radius: 10px; border: 1px solid #bbf7d0;
            cursor: pointer; text-decoration: none; transition: all 0.2s;
        }
        .btn-success:hover { background: #dcfce7; }

        /* Status badges */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.3px; }
        .badge-diterima   { background: #dbeafe; color: #1d4ed8; }
        .badge-dicuci     { background: #e0f2fe; color: #0369a1; }
        .badge-dikeringkan{ background: #fef3c7; color: #d97706; }
        .badge-disetrika  { background: #f3e8ff; color: #7c3aed; }
        .badge-siap       { background: #d1fae5; color: #047857; }
        .badge-selesai    { background: #f1f5f9; color: #475569; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead tr { background: #f8faff; }
        .data-table th { padding: 12px 16px; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px; border-bottom: 2px solid #e8f0ff; text-align: left; }
        .data-table td { padding: 14px 16px; font-size: 13.5px; color: #374151; border-bottom: 1px solid #f1f5ff; }
        .data-table tbody tr:hover { background: #f8faff; }
        .data-table tbody tr:last-child td { border-bottom: none; }

        /* Form elements */
        .form-label { display: block; font-size: 12px; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .form-input {
            width: 100%; padding: 10px 14px; border-radius: 10px;
            border: 1.5px solid #e2e8f0; font-size: 13.5px; color: #1e293b;
            background: #fff; transition: border 0.2s, box-shadow 0.2s;
        }
        .form-input:focus { outline: none; border-color: #1a6fc4; box-shadow: 0 0 0 3px rgba(26,111,196,0.1); }
        .form-input.error { border-color: #ef4444; }

        /* Alert */
        .alert-success {
            padding: 12px 16px; border-radius: 10px;
            background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46;
            font-size: 13.5px; font-weight: 600;
            display: flex; align-items: center; gap: 8px;
        }
        .alert-error {
            padding: 12px 16px; border-radius: 10px;
            background: #fef2f2; border: 1px solid #fca5a5; color: #7f1d1d;
            font-size: 13.5px;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .content-area { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="flex">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="logo-icon">🫧</div>
                <h1>CleanPro</h1>
                <p>Laundry Management System</p>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section-label">Main Menu</div>
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Dashboard
                </a>

                @if(auth()->user()->role !== 'pelanggan')
                <div class="nav-section-label">Manajemen</div>
                <a href="{{ route('services.index') }}" class="nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 7h10M7 12h6M7 17h10"/><rect x="3" y="3" width="18" height="18" rx="3"/></svg>
                    Layanan
                </a>
                <a href="{{ route('customers.index') }}" class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Pelanggan
                </a>
                @endif

                <div class="nav-section-label">Order</div>
                <a href="{{ route('orders.index') }}" class="nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Daftar Order
                </a>
                @if(auth()->user()->role !== 'pelanggan')
                <a href="{{ route('orders.create') }}" class="nav-item {{ request()->is('orders/create') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                    Terima Order
                </a>
                @endif
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div style="flex:1; min-width:0;">
                        <div class="user-name" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ auth()->user()->name }}</div>
                        <span class="user-role">{{ auth()->user()->role }}</span>
                    </div>
                </div>
                <div style="margin-top: 8px; display: flex; gap: 6px;">
                    <a href="{{ route('profile.edit') }}" style="flex:1; text-align:center; padding:7px; border-radius:8px; background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.7); font-size:12px; text-decoration:none;">Profil</a>
                    <form method="POST" action="{{ route('logout') }}" style="flex:1;">
                        @csrf
                        <button type="submit" style="width:100%; padding:7px; border-radius:8px; background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.7); font-size:12px; border:none; cursor:pointer;">Logout</button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main content -->
        <div class="main-content" style="flex:1;">
            <!-- Top bar -->
            <div class="topbar">
                <div class="page-title">
                    @isset($header)
                        {{ $header }}
                    @else
                        CleanPro
                    @endisset
                </div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="font-size:12px; color:#64748b;">{{ now()->format('d F Y') }}</div>
                    <div style="width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#1a6fc4,#0891b2); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:13px;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            <div class="content-area" style="padding-bottom:0;">
                @if(session('success'))
                    <div class="alert-success mb-4">
                        <span>✅</span> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert-error mb-4">❌ {{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert-error mb-4">
                        <strong>⚠️ Mohon perbaiki kesalahan berikut:</strong>
                        <ul style="margin: 8px 0 0 16px; list-style: disc;">
                            @foreach($errors->all() as $error)
                                <li style="font-size:13px; margin-top:4px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <div class="content-area">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
