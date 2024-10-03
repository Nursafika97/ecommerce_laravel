<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">Teknik Informatika | RPL</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">RPL</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <!-- Correct Route::is syntax for 'admin.dashboard' -->
            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <!-- Fixed syntax error and use route() for the href -->
            <li class="{{ Route::is('admin.product') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.product') }}">
                    <i class="fas fa-box"></i> <span>Produk</span>
                </a>
            </li>
        </ul>
    </aside>
</div>