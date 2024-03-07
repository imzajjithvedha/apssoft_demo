<nav class="navbar navbar-expand-lg">
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.dashboard.index') }}" class="sidebar-logo"><img src="{{ url('/storage/dashboard_logo.png') }}" alt="Logo" class="logo"></a>

        <div class="sidebar-collapse">
            <i class="bi bi-text-left collapse-icon"></i>
            <h3 class="logo-text">Stock Management</h3>
        </div>
    </div>
    
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</a>
                <ul class="dropdown-menu">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>