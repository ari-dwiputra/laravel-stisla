<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">System</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">SYS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ (request()->is('/') || request()->is('profile')) ? 'active' : '' }}"><a class="nav-link" href="/"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
            <li class="nav-item dropdown {{ (request()->is('user') || request()->is('user/*') || request()->is('role') || request()->is('role/*')) ? 'active' : '' }}">
                <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span>Settings</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ (request()->is('user') || request()->is('user/*')) ? 'active' : '' }}"><a class="nav-link" href="/user">User</a></li>
                    <li class="{{ (request()->is('role') || request()->is('role/*')) ? 'active' : '' }}"><a class="nav-link" href="/role">Role</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>