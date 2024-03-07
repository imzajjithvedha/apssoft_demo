<nav class="sidebar">

    <ul class="components">
        <h6 class="menu-title">Main</h6>

        <li><a href="{{ route('admin.dashboard.index') }}" class="link {{ Request::segment(2) == 'dashboard' ? 'active' : null }}"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a></li>

        <li><a href="{{ route('admin.brands.index') }}" class="link {{ Request::segment(2) == 'brands' ? 'active' : null }}"><i class="bi bi-bing"></i><span>Brands</span></a></li>

        <li><a href="{{ route('admin.categories.index') }}" class="link {{ Request::segment(2) == 'categories' ? 'active' : null }}"><i class="bi bi-tags-fill"></i><span>Categories</span></a></li>

        <li><a href="{{ route('admin.products.index') }}" class="link {{ Request::segment(2) == 'products' ? 'active' : null }}"><i class="bi bi-star-fill"></i><span>Products</span></a></li>

        <li><a href="{{ route('admin.purchases.index') }}" class="link {{ Request::segment(2) == 'purchases' ? 'active' : null }}"><i class="bi bi-arrow-bar-left"></i><span>Purchases</span></a></li>

        <li><a href="{{ route('admin.sales.index') }}" class="link {{ Request::segment(2) == 'sales' ? 'active' : null }}"><i class="bi bi-arrow-bar-right"></i><span>Sales</span></a></li>
    </ul>

    <ul class="components">
        <h6 class="menu-title">Administration</h6>

        <li><a href="{{ route('admin.users.index') }}" class="link {{ Request::segment(2) == 'users' ? 'active' : null }}"><i class="bi bi-person-add"></i><span>Users</span></a></li>

        <li><a href="{{ route('admin.profile.index') }}" class="link {{ Request::segment(2) == 'profile' ? 'active' : null }}"><i class="bi bi-info-square"></i><span>Profile</span></a></li>
    </ul>

</nav>
