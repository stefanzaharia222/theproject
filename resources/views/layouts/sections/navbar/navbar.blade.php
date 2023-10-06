@php

$containerNav = $containerNav ?? 'container-xxl';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="{{$containerNav}}">
    @endif
    <!--  Brand demo (display only for navbar-full and hide on below xl) -->
    @if(isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
      <a href="{{url('/')}}" class="app-brand-link gap-2">
        <img src="{{ asset('logo.png') }}" alt="">
        <span class="app-brand-logo demo">
{{--          @include('_partials.macros',["width"=>25,"withbg"=>'#666cff'])--}}
        </span>
        <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
      </a>
    </div>
    @endif

    <!-- ! Not required for layout-without-menu -->
    @if(!isset($navbarHideToggle))
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="mdi mdi-menu mdi-24px"></i>
      </a>
    </div>
    @endif

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

      @if(!isset($menuHorizontal))
      <!-- Search -->
      <div class="navbar-nav align-items-center">
        <div class="nav-item navbar-search-wrapper mb-0">
          <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:void(0);">
            <i class="mdi mdi-magnify mdi-24px scaleX-n1-rtl"></i>
            <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
          </a>
        </div>
      </div>
      <!-- /Search -->
      @endif

      <ul class="navbar-nav flex-row align-items-center ms-auto">
        @if(isset($menuHorizontal))
        <!-- Search -->
        <li class="nav-item navbar-search-wrapper me-2 me-xl-0">
          <a class="nav-link search-toggler" href="javascript:void(0);">
            <i class="mdi mdi-magnify mdi-24px scaleX-n1-rtl"></i>
          </a>
        </li>
        <!-- /Search -->
        @endif
        <!-- Language -->
       @include('layouts.sections.navbar.nav_sections.lang')<!--/ Language -->

        <!-- Style Switcher -->
        @include('layouts.sections.navbar.nav_sections.display_mode')
        <!--/ Style Switcher -->

        <!-- Quick links  -->
        @include('layouts.sections.navbar.nav_sections.quick_links')
        <!-- Quick links -->

        <!-- Notification -->
        @include('layouts.sections.navbar.nav_sections.notifications')
        <!--/ Notification -->

        <!-- User -->
        @include('layouts.sections.navbar.nav_sections.profile')
        <!--/ User -->
      </ul>
    </div>

    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper {{ isset($menuHorizontal) ? $containerNav : '' }} d-none">
      <input type="text" class="form-control search-input {{ isset($menuHorizontal) ? '' : $containerNav }} border-0" placeholder="Search..." aria-label="Search...">
      <i class="mdi mdi-close search-toggler cursor-pointer"></i>
    </div>
    @if(!isset($navbarDetached))
  </div>
  @endif
</nav>
<!-- / Navbar -->
