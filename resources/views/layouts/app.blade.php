<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CleanPro') }} — Laundry Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }

        body { background: #f0f4f8; min-height: 100vh; margin: 0; }

        /* ── Sidebar ─────────────────────────────── */
        .sidebar {
            width: 244px; min-height: 100vh;
            background: #0f3460;
            position: fixed; top: 0; left: 0; z-index: 50;
            display: flex; flex-direction: column;
        }

        .sidebar-brand {
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex; align-items: center; gap: 12px;
        }
        .brand-logo {
            width: 40px; height: 40px; border-radius: 10px;
            background: #1a6fc4;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .brand-logo svg { width: 22px; height: 22px; color: #fff; }
        .brand-text h1 { color: #fff; font-size: 16px; font-weight: 800; margin: 0; letter-spacing: -0.3px; }
        .brand-text p { color: rgba(255,255,255,0.45); font-size: 10px; margin: 2px 0 0; }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .nav-section-label {
            color: rgba(255,255,255,0.35); font-size: 10px; font-weight: 700;
            letter-spacing: 1.4px; text-transform: uppercase;
            padding: 14px 8px 6px; display: block;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            color: rgba(255,255,255,0.6); font-size: 13.5px; font-weight: 500;
            text-decoration: none; margin-bottom: 2px;
            transition: all 0.15s;
        }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.9); }
        .nav-item.active { background: #1a6fc4; color: #fff; font-weight: 600; }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; stroke: currentColor; fill: none; stroke-width: 1.8; }

        .sidebar-footer {
            padding: 14px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .user-card {
            background: rgba(255,255,255,0.06);
            border-radius: 10px; padding: 10px 12px;
            display: flex; align-items: center; gap: 10px;
        }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: #1a6fc4;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; color: #fff; flex-shrink: 0;
        }
        .user-name { color: #fff; font-size: 13px; font-weight: 600; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .role-badge {
            display: inline-block; font-size: 9px; font-weight: 700;
            padding: 2px 7px; border-radius: 4px; margin-top: 3px;
            background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.8);
            text-transform: uppercase; letter-spacing: 0.6px;
        }
        .footer-actions { display: flex; gap: 6px; margin-top: 8px; }
        .footer-btn {
            flex: 1; padding: 7px 0; border-radius: 7px;
            background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.6);
            font-size: 12px; font-weight: 500; text-align: center;
            border: none; cursor: pointer; text-decoration: none;
            transition: all 0.15s;
        }
        .footer-btn:hover { background: rgba(255,255,255,0.14); color: rgba(255,255,255,0.9); }

        /* ── Main Layout ─────────────────────────── */
        .main-wrap { margin-left: 244px; min-height: 100vh; display: flex; flex-direction: column; }

        .topbar {
            height: 60px; background: #fff;
            border-bottom: 1px solid #e4eaf2;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 30px;
            position: sticky; top: 0; z-index: 40;
        }
        .topbar-title { font-size: 15px; font-weight: 700; color: #1e293b; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .topbar-date { font-size: 12px; color: #94a3b8; }
        .topbar-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: #1a6fc4;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 12px;
        }

        .page-content { padding: 26px 30px; flex: 1; }

        /* ── Components ──────────────────────────── */
        .card {
            background: #fff; border-radius: 14px;
            border: 1px solid #e4eaf2;
            box-shadow: 0 1px 6px rgba(15,52,96,0.06);
        }
        .card-header {
            padding: 16px 22px; border-bottom: 1px solid #f0f4f8;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-title { font-size: 14px; font-weight: 700; color: #1e293b; }
        .card-body { padding: 22px; }

        /* Stat Card */
        .stat-card { border-radius: 14px; padding: 20px 22px; border: 1px solid transparent; }
        .stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
        .stat-icon svg { width: 22px; height: 22px; stroke: currentColor; fill: none; stroke-width: 1.8; }
        .stat-value { font-size: 26px; font-weight: 800; line-height: 1; }
        .stat-label { font-size: 12px; font-weight: 500; margin-top: 4px; opacity: 0.75; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 6px; font-weight: 600; font-size: 13px; padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer; text-decoration: none; transition: all 0.15s; }
        .btn-primary { background: #1a6fc4; color: #fff; }
        .btn-primary:hover { background: #155fa0; color: #fff; }
        .btn-secondary { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        .btn-secondary:hover { background: #e2e8f0; }
        .btn-danger { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .btn-danger:hover { background: #fee2e2; }
        .btn-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .btn-success:hover { background: #dcfce7; }
        .btn svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; }

        /* Status badges */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.2px; }
        .badge-diterima    { background: #dbeafe; color: #1d4ed8; }
        .badge-dicuci      { background: #e0f2fe; color: #0369a1; }
        .badge-dikeringkan { background: #fef3c7; color: #b45309; }
        .badge-disetrika   { background: #f3e8ff; color: #7c3aed; }
        .badge-siap        { background: #dcfce7; color: #15803d; }
        .badge-selesai     { background: #f1f5f9; color: #64748b; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead tr { background: #f8fafc; }
        .data-table th { padding: 11px 16px; font-size: 10.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.9px; border-bottom: 1px solid #e4eaf2; text-align: left; white-space: nowrap; }
        .data-table td { padding: 13px 16px; font-size: 13.5px; color: #374151; border-bottom: 1px solid #f1f5f9; }
        .data-table tbody tr:hover { background: #f8fafc; }
        .data-table tbody tr:last-child td { border-bottom: none; }

        /* Form */
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 11.5px; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .form-input { width: 100%; padding: 9px 13px; border-radius: 8px; border: 1.5px solid #d1d9e6; font-size: 13.5px; color: #1e293b; background: #fff; transition: border 0.15s, box-shadow 0.15s; }
        .form-input:focus { outline: none; border-color: #1a6fc4; box-shadow: 0 0 0 3px rgba(26,111,196,0.08); }
        select.form-input { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 32px; }

        /* Alert */
        .alert { padding: 12px 16px; border-radius: 9px; font-size: 13.5px; margin-bottom: 16px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #7f1d1d; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; stroke: currentColor; fill: none; stroke-width: 2; }

        /* Divider */
        .section-label { font-size: 10.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
    </style>
</head>
<body>
<div style="display:flex;">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8">
                    <path d="M4 4h16v2a8 8 0 0 1-8 8 8 8 0 0 1-8-8V4z"/>
                    <path d="M12 14v6M8 20h8"/>
                </svg>
            </div>
            <div class="brand-text">
                <h1>CleanPro</h1>
                <p>Laundry Management</p>
            </div>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section-label">Main</span>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                Dashboard
            </a>

            @if(auth()->user()->role !== 'pelanggan')
            <span class="nav-section-label">Manajemen</span>
            <a href="{{ route('services.index') }}" class="nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
                Jenis Layanan
            </a>
            <a href="{{ route('customers.index') }}" class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Pelanggan
            </a>
            @endif

            <span class="nav-section-label">Order</span>
            <a href="{{ route('orders.index') }}" class="nav-item {{ request()->routeIs('orders.index') || request()->routeIs('orders.show') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10,9 9,9 8,9"/></svg>
                Daftar Order
            </a>
            @if(auth()->user()->role !== 'pelanggan')
            <a href="{{ route('orders.create') }}" class="nav-item {{ request()->is('orders/create') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                Terima Order Baru
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div style="flex:1; min-width:0;">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <span class="role-badge">{{ auth()->user()->role }}</span>
                </div>
            </div>
            <div class="footer-actions">
                <a href="{{ route('profile.edit') }}" class="footer-btn">Profil</a>
                <form method="POST" action="{{ route('logout') }}" style="flex:1; display:flex;">
                    @csrf
                    <button type="submit" class="footer-btn" style="flex:1;">Logout</button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main -->
    <div class="main-wrap">
        <div class="topbar">
            <div class="topbar-title">
                @isset($header){{ $header }}@else CleanPro @endisset
            </div>
            <div class="topbar-right">
                <span class="topbar-date">{{ now()->isoFormat('D MMMM YYYY') }}</span>
                <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            </div>
        </div>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-error" style="flex-direction:column; align-items:flex-start;">
                    <div style="display:flex; align-items:center; gap:8px; font-weight:700;">
                        <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Terdapat kesalahan pada form
                    </div>
                    <ul style="margin: 8px 0 0 20px; list-style:disc;">
                        @foreach($errors->all() as $error)
                            <li style="font-size:13px; margin-top:3px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>
</body>
</html>
