<div class="navbar-bg"></div>
  <nav class="navbar navbar-expand-lg main-navbar">
      <ul class="navbar-nav mr-auto">
          <li><a href="javascript:void(0)" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
      </ul>
      <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="javascript:void(0)" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
          <img alt="image" src="{{ auth()->user()->photo != '' ? asset('storage/images/user/' . auth()->user()->photo) : asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
          <div class="d-sm-none d-lg-inline-block">{{ Auth::user()->name }}</div></a>
          <div class="dropdown-menu dropdown-menu-right">
            <a href="/profile" class="dropdown-item has-icon">
              <i class="far fa-user"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
          </div>
        </li>
      </ul>
  </nav>