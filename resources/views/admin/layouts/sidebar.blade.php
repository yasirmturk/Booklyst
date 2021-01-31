<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-navy">
    <!-- Brand Logo -->
    <a href="{{ route('admin.index') }}" class="brand-link">
        <img src="{{ asset('images/vendor/admin-lte/dist/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/vendor/admin-lte/dist/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.index') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link bg-maroon">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header">SYSTEM</li>
                <li class="nav-item">
                    <a href="{{ route('admin.businesses.index') }}" class="nav-link {{ url()->current() == route('admin.businesses.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-spray-can"></i>
                        <p>Businesses<span class="badge badge-info right">99+</span></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.services.index') }}" class="nav-link {{ url()->current() == route('admin.services.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-spa"></i>
                        <p>Services<span class="badge badge-info right">99+</span></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ url()->current() == route('admin.bookings.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Bookings<span class="badge badge-info right">99+</span></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ url()->current() == route('admin.orders.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-basket"></i>
                        <p>Orders<span class="badge badge-info right">99+</span></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.index') }}" class="nav-link {{ url()->current() == route('admin.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-pound-sign"></i>
                        <p>Payments<span class="badge badge-info right">99+</span></p>
                    </a>
                </li>
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link bg-secondary">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>MORE<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview bg-secondary">
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link {{ url()->current() == route('admin.products.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-barcode"></i>
                                <p>Products<span class="badge badge-info right">99+</span></p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">USERS</li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ url()->current() == route('admin.users.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>All Users<span class="badge badge-info right">99+</span></p>
                    </a>
                </li>
                <li class="nav-header">SETTINGS</li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.categories.index') }}" class="nav-link {{ url()->current() == route('admin.settings.categories.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Categories<span class="badge badge-info right">2</span></p>
                    </a>
                </li>
                <li class="nav-header">DEMO</li>
                <li class="nav-item">
                    <a href="{{ route('admin.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Widgets<span class="right badge badge-danger">New</span></p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
