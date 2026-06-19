<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Bengkel Honda AHASS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/bengkel-dashboard.css?v={{ time() }}">
</head>
<body>
    <div class="bengkel-shell">
        <aside class="bengkel-sidebar">
            <div class="bengkel-brand">
                <span class="bengkel-brand-mark"><i class="bi bi-wrench-adjustable-circle"></i></span>
                <div>
                    <div class="bengkel-brand-name">AHASS</div>
                    <div class="bengkel-brand-sub">Bengkel resmi Honda</div>
                </div>
            </div>

            <nav class="bengkel-nav">
                <a class="bengkel-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>
                <a class="bengkel-nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">
                    <i class="bi bi-person-lines-fill"></i> Pelanggan
                </a>
                <a class="bengkel-nav-link {{ request()->routeIs('motor.*') ? 'active' : '' }}" href="{{ route('motor.index') }}">
                    <i class="bi bi-bicycle"></i> Motor
                </a>
                <a class="bengkel-nav-link {{ request()->routeIs('servis.create', 'servis.store') ? 'active' : '' }}" href="{{ route('servis.create') }}">
                    <i class="bi bi-tools"></i> Servis & perbaikan
                </a>
                <a class="bengkel-nav-link {{ request()->routeIs('pkb.*') ? 'active' : '' }}" href="{{ route('pkb.index') }}">
                    <i class="bi bi-clipboard-check"></i> PKB
                </a>
                <a class="bengkel-nav-link {{ request()->routeIs('mekanik.*') ? 'active' : '' }}" href="{{ route('mekanik.index') }}">
                    <i class="bi bi-person-badge"></i> Mekanik
                </a>
                <a class="bengkel-nav-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}" href="{{ route('jadwal.index') }}">
                    <i class="bi bi-calendar-week"></i> Jadwal mekanik
                </a>
                <a class="bengkel-nav-link {{ request()->routeIs('sparepart.*') ? 'active' : '' }}" href="{{ route('sparepart.index') }}">
                    <i class="bi bi-box-seam"></i> Sparepart & stok
                </a>
                <a class="bengkel-nav-link {{ request()->routeIs('servis.index') ? 'active' : '' }}" href="{{ route('servis.index') }}">
                    <i class="bi bi-clock-history"></i> Riwayat Servis
                </a>
            </nav>
        </aside>

        <div class="bengkel-main">
            <header class="bengkel-topbar">
                <h1 class="bengkel-page-title">@yield('title', 'Dashboard')</h1>
                <div class="bengkel-topbar-user" style="display:flex; align-items:center; gap: 1rem;">
                    <div style="display:flex; align-items:center; gap: 0.5rem;">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ Auth::user() ? Auth::user()->name : 'Admin' }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background:none; border:none; color:var(--primary); cursor:pointer; font-weight:600; font-size: 0.875rem;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="bengkel-content">
                @if (session('success'))
                    <div class="bengkel-alert bengkel-alert--success">{{ session('success') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
