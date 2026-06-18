<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'Dashboard') - Bengkel Honda AHASS</title>

  <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/base/vendor.bundle.base.css') }}">
  @stack('styles')
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
</head>
<body>
  <div class="container-scroller">

    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
          <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">
            <span class="text-white"><i class="mdi mdi-wrench"></i> AHASS</span>
          </a>
          <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
            <i class="mdi mdi-wrench text-white"></i>
          </a>
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-sort-variant"></span>
          </button>
        </div>
      </div>

      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-4 w-100">
          <li class="nav-item nav-search d-none d-lg-block w-100">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="search"><i class="mdi mdi-magnify"></i></span>
              </div>
              <input type="text" class="form-control" placeholder="Cari data...">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <i class="mdi mdi-account-circle text-white" style="font-size:28px;"></i>
              <span class="nav-profile-name">Admin bengkel</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item"><i class="mdi mdi-logout text-primary"></i> Logout</a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>

    <div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ Route::has('pelanggan.index') ? route('pelanggan.index') : '#' }}">
              <i class="mdi mdi-account-multiple menu-icon"></i>
              <span class="menu-title">Pelanggan</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('motor.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ Route::has('motor.index') ? route('motor.index') : '#' }}">
              <i class="mdi mdi-motorbike menu-icon"></i>
              <span class="menu-title">Motor</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('mekanik.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ Route::has('mekanik.index') ? route('mekanik.index') : '#' }}">
              <i class="mdi mdi-hard-hat menu-icon"></i>
              <span class="menu-title">Mekanik</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('sparepart.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ Route::has('sparepart.index') ? route('sparepart.index') : '#' }}">
              <i class="mdi mdi-cogs menu-icon"></i>
              <span class="menu-title">Sparepart</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ Route::has('jadwal.index') ? route('jadwal.index') : '#' }}">
              <i class="mdi mdi-calendar-clock menu-icon"></i>
              <span class="menu-title">Jadwal Mekanik</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('servis.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ Route::has('servis.index') ? route('servis.index') : '#' }}">
              <i class="mdi mdi-toolbox menu-icon"></i>
              <span class="menu-title">Servis</span>
            </a>
          </li>
        </ul>
      </nav>

      <div class="main-panel">
        <div class="content-wrapper">
          @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
          @endif

          @yield('content')
        </div>

        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">&copy; {{ date('Y') }} Bengkel Honda AHASS</span>
          </div>
        </footer>
      </div>
    </div>
  </div>

  <script src="{{ asset('vendors/base/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('js/off-canvas.js') }}"></script>
  <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('js/template.js') }}"></script>
  @stack('scripts')
</body>
</html>