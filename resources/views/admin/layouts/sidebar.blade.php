<a href="index3.html" class="brand-link">
  <img src="{{ asset('adminlte') }}/dist/img/AdminLTELogo.png" alt="{{ config('app.name') }}"
       class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
</a>

<div class="sidebar">
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ auth()->user()->profile_photo_url }}" class="img-circle elevation-2" alt="{{ auth()->user()->name }}">
    </div>
    <div class="info">
      <a href="#" class="d-block">{{ auth()->user()->name }}</a>
    </div>
  </div>

  <div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
      <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-sidebar">
          <i class="fas fa-search fa-fw"></i>
        </button>
      </div>
    </div>
  </div>

  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard*') || request()->routeIs('admin.school-level*') ? 'active' : '' }}"
        >
          <i class="nav-icon fas fa-columns"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.village.index') }}"
           class="nav-link {{ request()->routeIs('admin.village*') || request()->routeIs('admin.school*') && !request()->routeIs('admin.school-level*') ? 'active' : '' }}"
        >
          <i class="nav-icon fas fa-city"></i>
          <p>Kelurahan</p>
        </a>
      </li>
      <li class="nav-item">
        <a onclick="event.preventDefault();document.getElementById('form-logout').submit()"
           href="{{ route('logout') }}" class="nav-link"
        ><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p>
        </a>
        <form action="{{ route('logout') }}" method="POST"
              id="form-logout" class="d-none"
        >@csrf
        </form>
      </li>
    </ul>
  </nav>
</div>