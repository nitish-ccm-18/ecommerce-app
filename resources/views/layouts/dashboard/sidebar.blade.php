@can('isAdmin')
<!-- Admin Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Vendor Dashboard</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ (request()->is(route('admin.dashboard'))) ? 'active' : '' }}">
        <a class="nav-link"
            href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">



    <!-- Nav Item - Charts -->
    <li class="nav-item {{ (request()->is(route('categories.index'))) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('categories.index')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Categories</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ (request()->is('/products')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('products.index')}}">
            <i class="fas fa-fw fa-table"></i>
            <span>Products</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ (request()->is('vendor/coupons')) ? 'active' : '' }}">
        <a class="nav-link" href="/vendor/coupons">
            <i class="fas fa-fw fa-table"></i>
            <span>Coupons</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ (request()->is('vendor/orders')) ? 'active' : '' }}">
        <a class="nav-link" href="/vendor/orders">
            <i class="fas fa-fw fa-table"></i>
            <span>Orders</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Admin Sidebar -->
@elsecan('isUser')
    <!-- User Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">e-commerce</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item nav-item {{ (request()->is('users/dashboard')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('user.dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">



    <!-- Nav Item - Orders -->
    <li class="nav-item  {{ (request()->is('user/orders')) ? 'active' : '' }}">
        <a class="nav-link" href="/user/orders">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Orders</span></a>
    </li>
    <!-- Nav Item - Coupons -->
    <li class="nav-item {{ (request()->is('user/coupons')) ? 'active' : '' }}">
        <a class="nav-link" href="/user/orders">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Coupons</span></a>
    </li>

    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of User Sidebar -->
@endcan


