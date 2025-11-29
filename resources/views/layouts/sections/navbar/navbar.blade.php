@php
$containerNav = ($configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
@endphp

<!-- Navbar -->
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="{{$containerNav}}">

    <!--  Brand demo (display only for navbar-full and hide on below xl) -->
    @if(isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
      <a href="{{url('/')}}" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">
          @include('_partials.macros')
        </span>
        <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
      </a>

      @if(isset($menuHorizontal))
      <!-- Display menu close icon only for horizontal-menu with navbar-full -->
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
        <i class="bx bx-x bx-sm align-middle"></i>
      </a>
      @endif
    </div>
    @endif

    <!-- ! Not required for layout-without-menu -->
    @if(!isset($navbarHideToggle))
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
      </a>
    </div>
    @endif

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

      @if($configData['hasCustomizer'] == true)
      <!-- Style Switcher -->
      <div class="navbar-nav align-items-center">
        <div class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <i class='bx bx-sm'></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-start dropdown-styles">
            <li>
              <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                <span class="align-middle"><i class='bx bx-sun me-2'></i>Light</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                <span class="align-middle"><i class="bx bx-moon me-2"></i>Dark</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                <span class="align-middle"><i class="bx bx-desktop me-2"></i>System</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <!--/ Style Switcher -->
      @endif

      <ul class="navbar-nav flex-row align-items-center ms-auto">

        <!-- User -->
        @if(Auth::guard('admin')->check())
        <li class="me-4 d-none1">
          <i class='bx bx-user me-2'></i>
          <span class="align-middle">{{auth()->user()->name}}</span>
        </li>
        <li>
          <a class="dropdown-item" href="{{ route('admin.logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class='bx bx-power-off me-2'></i>
            <span class="align-middle">@lang('Logout')</span>
          </a>
        </li>
        <form method="POST" id="logout-form" action="{{ route('admin.logout') }}">
          @csrf
        </form>
        @else
        <li>
          <a class="dropdown-item" href="{{ Route::has('admin.login') ? route('admin.login') : url('admin/login') }}">
            <i class='bx bx-log-in me-2'></i>
            <span class="align-middle">@lang('Login')</span>
          </a>
        </li>
        @endif
        <!--/ User -->
      </ul>
    </div>

  </div>
</nav>
<!-- / Navbar -->