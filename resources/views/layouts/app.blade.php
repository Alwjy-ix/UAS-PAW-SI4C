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
                @php
                    $name = Auth::user() ? Auth::user()->name : 'Admin User';
                    $words = explode(' ', trim($name));
                    $initials = '';
                    if (count($words) >= 2) {
                        $initials = strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
                    } else {
                        $initials = strtoupper(substr($name, 0, min(2, strlen($name))));
                    }
                @endphp
                <div class="bengkel-topbar-profile-container" style="position: relative;">
                    <div class="bengkel-avatar-trigger" id="avatarTrigger">
                        {{ $initials }}
                    </div>
                    <div class="bengkel-dropdown-card" id="profileDropdown" style="display: none;">
                        <div class="bengkel-dropdown-header">
                            <div class="bengkel-avatar-lg">
                                {{ $initials }}
                            </div>
                            <div class="bengkel-user-name">{{ Auth::user() ? Auth::user()->name : 'Admin' }}</div>
                            <div class="bengkel-user-email">{{ Auth::user() ? Auth::user()->email : '' }}</div>
                            <div class="bengkel-user-joined">Member sejak {{ Auth::user() && Auth::user()->created_at ? Auth::user()->created_at->translatedFormat('M Y') : '' }}</div>
                        </div>
                        <div class="bengkel-dropdown-divider"></div>
                        <div class="bengkel-dropdown-actions">
                            <a href="{{ route('profile.edit') }}" class="bengkel-dropdown-btn">
                                <i class="bi bi-person-gear"></i> Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0; width: 100%;">
                                @csrf
                                <button type="submit" class="bengkel-dropdown-btn btn-logout-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trigger = document.getElementById('avatarTrigger');
            const dropdown = document.getElementById('profileDropdown');

            if (trigger && dropdown) {
                trigger.addEventListener('click', function (e) {
                    e.stopPropagation();
                    if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                        dropdown.style.display = 'block';
                    } else {
                        dropdown.style.display = 'none';
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!dropdown.contains(e.target) && e.target !== trigger) {
                        dropdown.style.display = 'none';
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
