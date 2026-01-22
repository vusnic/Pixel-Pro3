<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="description" content="Pxp3 Admin Dashboard">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/pixelpro3logo-trans.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/pixelpro3logo-trans.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/pixelpro3logo-trans.png') }}">
    <meta name="author" content="Pxp3 Squad">
    <meta name="generator" content="Laravel v{{ Illuminate\Foundation\Application::VERSION }}">
    <meta name="HandheldFriendly" content="true">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - Pxp3')</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Estilos para o Layout Admin Moderno */
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --navbar-height: 45px;
            --footer-height: 65px;
            --content-padding: 1.5rem;
            --card-border-radius: 0.75rem;
            --transition-speed: 0.3s;
            --bs-theme-primary: #843674; /* Cor magenta */
            --bs-theme-primary-rgb: 233, 76, 200; /* Valor RGB do magenta */
            --bs-primary: #843674;
            --bs-primary-rgb: 233, 76, 200;
        }
        
        body {
            overflow-x: hidden;
            background-color: var(--bs-dark);
        }
        
        /* Garantir que body tenha classe admin-area para aplicar estilos específicos */
        body.admin-area {
            background-color: #1a1a1a !important;
        }
        
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .main-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            z-index: 1040;
            overflow-y: auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed) ease;
            background-color: var(--bs-dark);
        }
        
        /* Navbar Styles */
        .main-header .navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--navbar-height);
            z-index: 1030;
            padding: 0 1.25rem;
            transition: all var(--transition-speed) ease;
            background-color: var(--bs-theme-primary, var(--bs-primary));
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            min-height: unset;
            display: flex;
            align-items: center;
        }
        
        .main-header .navbar .nav-link {
            padding: 0.35rem 0.6rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            height: var(--navbar-height);
        }
        
        .main-header .navbar .form-control {
            height: calc(1.5em + 0.4rem + 2px);
            padding: 0.2rem 0.5rem;
            font-size: 0.85rem;
        }
        
        .main-header .navbar .navbar-nav {
            display: flex;
            align-items: center;
            height: 100%;
        }
        
        .main-header .navbar .container-fluid {
            height: 100%;
            display: flex;
            align-items: center;
        }
        
        .main-header .navbar .btn {
            padding: 0.2rem 0.5rem;
            font-size: 0.85rem;
        }
        
        /* Content Wrapper */
        .content-wrapper {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            min-height: calc(100vh - var(--navbar-height) - var(--footer-height));
            padding: var(--content-padding);
            transition: all var(--transition-speed) ease;
            flex: 1;
            background-color: var(--bs-dark);
        }
        
        /* Content Header */
        .content-header {
            padding-bottom: 1.5rem;
        }
        
        .content-header h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 0;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            color: #6c757d;
        }
        
        .breadcrumb-item a {
            color: #d72ebd;
        }
        
        /* Card Links */
        .card-link {
            color: var(--bs-theme-primary, var(--bs-primary));
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .card-link:hover {
            color: rgba(var(--bs-theme-primary-rgb, var(--bs-primary-rgb)), 0.85);
        }
        
        /* Main Content */
        .content {
            padding: 0;
        }
        
        /* Cards */
        .card {
            border-radius: var(--card-border-radius);
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            background-color: var(--bs-dark);
        }
        
        .card-header {
            padding: 1.25rem 1.5rem;
            background-color: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Footer */
        .main-footer {
            margin-left: var(--sidebar-width);
            padding: 1rem 1.5rem;
            transition: all var(--transition-speed) ease;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background-color: var(--bs-dark);
        }
        
        /* Collapsed Sidebar */
        body.sidebar-collapse .main-sidebar {
            width: var(--sidebar-collapsed-width);
        }
        
        body.sidebar-collapse .navbar,
        body.sidebar-collapse .content-wrapper,
        body.sidebar-collapse .main-footer {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .main-sidebar {
                width: var(--sidebar-width);
                transform: translateX(calc(-1 * var(--sidebar-width)));
            }
            
            .navbar,
            .content-wrapper,
            .main-footer {
                margin-left: 0;
            }
            
            body.sidebar-open .main-sidebar {
                transform: translateX(0);
            }
            
            body.sidebar-collapse .main-sidebar {
                width: var(--sidebar-width);
                transform: translateX(calc(-1 * var(--sidebar-width)));
            }
            
            body.sidebar-collapse .navbar,
            body.sidebar-collapse .content-wrapper,
            body.sidebar-collapse .main-footer {
                margin-left: 0;
            }
        }
        
        /* Animations */
        .main-sidebar,
        .navbar,
        .content-wrapper,
        .main-footer {
            transition: all 0.3s ease-in-out;
        }
        
        /* Utils */
        .main-footer a {
            transition: color 0.2s ease;
        }
        
        .main-footer a:hover {
            color: var(--bs-theme-primary, var(--bs-primary)) !important;
        }
        
        /* Tables */
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            border-top: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 600;
            padding: 1rem;
        }
        
        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: rgba(255, 255, 255, 0.05);
        }
        
        /* Form Controls */
        .form-control, 
        .form-select {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: var(--bs-theme-primary, var(--bs-primary));
            box-shadow: 0 0 0 0.2rem rgba(var(--bs-theme-primary-rgb, var(--bs-primary-rgb)), 0.25);
        }
        
        /* Buttons */
        .btn {
            border-radius: 0.5rem;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
        }
        
        .btn-primary {
            background-color: var(--bs-theme-primary, var(--bs-primary));
            border-color: var(--bs-theme-primary, var(--bs-primary));
        }
        
        .btn-primary:hover {
            background-color: rgba(var(--bs-theme-primary-rgb, var(--bs-primary-rgb)), 0.9);
            border-color: rgba(var(--bs-theme-primary-rgb, var(--bs-primary-rgb)), 0.9);
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed bg-theme-primary text-theme-primary admin-area">
    <div class="wrapper">
        <!-- Navbar -->
        @include('components.admin.navbar')

        <!-- Main Sidebar Container -->
        @include('components.admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <br>
                    <br>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('header', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a class="text-tertiary" href="{{ route('admin.dashboard') }}">Home</a></li>
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <footer class="main-footer">
            <div class="container-fluid py-2">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-2 mb-md-0 d-flex align-items-center">
                        <a href="{{ route('home') }}" class="me-3">
                            <img src="{{ asset('img/nav-brand-logo.svg') }}" alt="Pxp3 Logo" class="navLogo"
                                style="height: 28px;">
                        </a>
                        <span class="text-secondary">Admin Panel</span>
                    </div>
                    <div class="col-md-4 text-center">
                        <p class="text-secondary mb-0">
                            &copy; {{ date('Y') }} Pxp3 | All Rights Reserved
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end text-center mt-2 mt-md-0">
                        <a href="{{ route('home') }}" class="text-decoration-none text-secondary me-3" target="_blank">
                            <i class="fas fa-globe me-1"></i> View Site
                        </a>
                        <a href="{{ route('admin.settings') }}" class="text-decoration-none text-secondary">
                            <i class="fas fa-cog me-1"></i> Settings
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Add admin-specific scripts here -->
    <script>
        // Toggle Sidebar
        document.addEventListener('DOMContentLoaded', function () {
            const toggleSidebarBtn = document.getElementById('sidebarToggle');
            if (toggleSidebarBtn) {
                toggleSidebarBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    // Em telas pequenas, abre e fecha a sidebar
                    if (window.innerWidth < 992) {
                        document.body.classList.toggle('sidebar-open');
                    } else {
                        // Em telas grandes, colapsa e expande a sidebar
                        document.body.classList.toggle('sidebar-collapse');
                    }
                });
            }

            // Fecha a sidebar quando clica fora dele em telas pequenas
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992 && 
                    document.body.classList.contains('sidebar-open') &&
                    !e.target.closest('.main-sidebar') && 
                    !e.target.closest('#sidebarToggle')) {
                    document.body.classList.remove('sidebar-open');
                }
            });

            // Ajustar o layout quando o tamanho da tela muda
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    document.body.classList.remove('sidebar-open');
                } else {
                    document.body.classList.remove('sidebar-collapse');
                }
            });

            // Forçar sempre tema dark no admin - sem possibilidade de mudança
            const forceAdminDarkTheme = () => {
                // Sempre forçar tema dark no admin
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                
                // Garantir que body tenha a classe admin-area
                document.body.classList.add('admin-area');
                
                // Sempre usar logo para tema dark
                document.querySelectorAll('.navLogo').forEach(el => {
                    el.setAttribute('src', '/img/nav-brand-logo.svg');
                });
                
                // Prevenir qualquer tentativa de mudança de tema
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'data-bs-theme') {
                            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                            if (currentTheme !== 'dark') {
                                document.documentElement.setAttribute('data-bs-theme', 'dark');
                            }
                        }
                    });
                });
                
                observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['data-bs-theme']
                });
            };
            
            // Aplicar tema dark imediatamente
            forceAdminDarkTheme();
            
            // Prevenir mudanças de tema automática do sistema
            if (window.setThemeBasedOnSystem) {
                window.setThemeBasedOnSystem = function() {
                    // Não fazer nada no admin - sempre dark
                    document.documentElement.setAttribute('data-bs-theme', 'dark');
                };
            }
            
            // Remover listeners de mudança de tema do sistema
            if (window.matchMedia) {
                const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
                if (mediaQuery.removeEventListener) {
                    mediaQuery.removeEventListener('change', window.setThemeBasedOnSystem);
                }
            }
        });
    </script>

    @yield('scripts')
</body>

</html> 