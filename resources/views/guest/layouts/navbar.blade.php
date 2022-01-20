<a href="{{ request()->url('') }}" class="navbar-brand">
  <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
       class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">TUGAS BESAR SIG</span>
</a>

<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"
>
  <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse order-3" id="navbarCollapse">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a href="{{ route('home') }}" class="nav-link">Home</a>
    </li>
  </ul>
</div>

<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
  @if (auth()->check())
    <li class="nav-item dropdown">
      <a class="nav-link" href="{{ route('admin.dashboard') }}"
      >Dashboard</a>
    </li>
  @endif
  @if (Route::has('login') && !request()->routeIs('login') && !auth()->check())
    <li class="nav-item dropdown">
      <a class="nav-link" href="{{ route('login') }}"
      >Log in</a>
    </li>
  @endif
</ul>