<nav class="main-header navbar navbar-expand navbar-dark fixed-top bg-theme-primary border-bottom-0">
    <!-- Left navbar links -->
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" id="sidebarToggle" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-lg-inline-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center">Dashboard</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ms-auto">
            <!-- Search -->
            <li class="nav-item d-none d-md-inline-block me-3">
                <div class="d-flex align-items-center h-100">
                    <form class="form-inline m-0">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input class="form-control form-control-sm bg-dark bg-opacity-50 border-0 rounded-start-pill text-white" type="search" placeholder="Search..." aria-label="Search">
                            <button class="btn btn-sm btn-dark rounded-end-pill border-0 px-3" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </li>
            
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown d-flex align-items-center me-2">
                <a class="nav-link d-flex align-items-center" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="far fa-bell fa-sm"></i>
                    <span class="badge rounded-pill bg-danger navbar-badge" style="font-size: 0.6rem; padding: 0.15rem 0.35rem; top: 2px; right: 0px;">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0 border-0 shadow-lg rounded-4 bg-dark">
                    <span class="dropdown-item dropdown-header bg-tertiary bg-opacity-10 rounded-top-4 py-3">15 Notifications</span>
                    <div class="dropdown-divider border-secondary"></div>
                    <a href="#" class="dropdown-item d-flex align-items-center py-3 px-4 text-white-50">
                        <span class="me-3">
                            <i class="fas fa-envelope text-tertiary"></i>
                        </span>
                        <div>
                            <p class="mb-0 text-white">4 new messages</p>
                            <small class="text-secondary">3 mins ago</small>
                        </div>
                    </a>
                    <div class="dropdown-divider border-secondary"></div>
                    <a href="#" class="dropdown-item text-center py-3 text-tertiary">See All Notifications</a>
                </div>
            </li>
            
            <!-- TODO: Implementar Theme Switcher -->
            {{-- <li class="nav-item d-flex align-items-center">
                <a class="nav-link d-flex align-items-center" href="#" id="themeSwitcherAdmin">
                    <i class="fas fa-moon fa-sm"></i>
                </a>
            </li> --}}
            
            <!-- User Dropdown Menu -->
            <li class="nav-item dropdown d-flex align-items-center">
                <a class="nav-link d-flex align-items-center" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random&color=fff&size=128" 
                         class="rounded-circle border border-2 border-white" alt="{{ Auth::user()->name }}" 
                         width="32" height="32">
                    <span class="d-none d-md-inline-block ms-2">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end p-0 border-0 shadow-lg rounded-4 bg-dark">
                    <div class="p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 text-white fw-semibold">{{ Auth::user()->name }}</h6>
                                <p class="text-white-50 mb-0 small">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-2">
                        <a href="#" class="dropdown-item py-2 px-3 rounded-3 text-white-50 hover-bg-tertiary">
                            <i class="fas fa-user me-2 text-tertiary"></i> My Profile
                        </a>
                        <a href="{{ route('admin.settings') }}" class="dropdown-item py-2 px-3 rounded-3 text-white-50 hover-bg-tertiary">
                            <i class="fas fa-cog me-2 text-tertiary"></i> Settings
                        </a>
                    </div>
                    <div class="p-2 mt-2 border-top border-secondary">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 px-3 rounded-3 text-danger hover-bg-danger hover-text-white">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>

<style>
.hover-bg-tertiary:hover {
    background-color: rgba(233, 76, 200, 0.1) !important;
    color: #fff !important;
}
.hover-bg-danger:hover {
    background-color: rgba(220, 53, 69, 0.1) !important;
}
.hover-text-white:hover {
    color: #fff !important;
}
</style> 