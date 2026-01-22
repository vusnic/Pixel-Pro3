<aside class="main-sidebar sidebar-dark-primary bg-dark elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link text-center bg-theme-primary border-bottom-0 px-5 py-3 d-flex justify-content-center align-items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
            <img src="{{ asset('img/nav-brand-logo.svg') }}" alt="Pxp3 Logo" class="fw-bolder navLogo"
                style="height: 83px!important; width:auto;">
        </a>
    </div>
    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.leads.index') }}" class="nav-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>Leads</p>
                    </a>
                </li>

                <!-- Users -->
                <li class="nav-item {{ request()->routeIs('admin.users*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List All</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.create') }}"
                                class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New User</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Portfolio -->
                <li class="nav-item {{ request()->routeIs('admin.portfolio*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.portfolio*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-image"></i>
                        <p>
                            Portfolio
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.portfolio.index') }}"
                                class="nav-link {{ request()->routeIs('admin.portfolio.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Projects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.portfolio.create') }}"
                                class="nav-link {{ request()->routeIs('admin.portfolio.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Project</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.portfolio.categories') }}"
                                class="nav-link {{ request()->routeIs('admin.portfolio.categories') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('portfolio') }}" class="nav-link" target="_blank">
                                <i class="far fa-eye nav-icon"></i>
                                <p>View Portfolio</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Services -->
                <li class="nav-item {{ request()->routeIs('admin.services*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-server"></i>
                        <p>
                            Services
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.services.index') }}"
                                class="nav-link {{ request()->routeIs('admin.services.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Services</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.services.create') }}"
                                class="nav-link {{ request()->routeIs('admin.services.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Service</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('services') }}" class="nav-link" target="_blank">
                                <i class="far fa-eye nav-icon"></i>
                                <p>View Services</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Blog -->
                <li class="nav-item {{ request()->routeIs('admin.blog*') || request()->routeIs('admin.categories*') || request()->routeIs('admin.tags*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.blog*') || request()->routeIs('admin.categories*') || request()->routeIs('admin.tags*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-blog"></i>
                        <p>
                            Blog
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.blog.index') }}"
                                class="nav-link {{ request()->routeIs('admin.blog.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Posts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.blog.create') }}"
                                class="nav-link {{ request()->routeIs('admin.blog.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Post</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}"
                                class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.tags.index') }}"
                                class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('blog') }}" class="nav-link" target="_blank">
                                <i class="far fa-eye nav-icon"></i>
                                <p>View Blog</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Contratos -->
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.contract*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>
                            Contracts
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.contracts.index') }}"
                                class="nav-link {{ request()->routeIs('admin.contracts.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Contracts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contracts.create') }}"
                                class="nav-link {{ request()->routeIs('admin.contracts.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Contract</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contract-templates.index') }}"
                                class="nav-link {{ request()->routeIs('admin.contract-templates.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Contract Templates</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a href="{{ route('admin.settings') }}"
                        class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Settings</p>
                    </a>
                </li>

                <li class="nav-header">WEBSITE</li>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link" target="_blank">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>View Site</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    <style>
        .sidebar {
            overflow-y: auto;
            padding-top: 1rem;
        }

        .nav-sidebar {
            margin-bottom: 20px;
        }

        .nav-sidebar .nav-item {
            width: 100%;
            margin-bottom: 0.25rem;
        }

        .nav-sidebar .nav-link {
            color: #c2c7d0;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            margin: 0 0.5rem;
            display: flex;
            align-items: center;
        }

        .nav-sidebar .nav-link i.nav-icon {
            margin-right: 0.75rem;
            font-size: 1.1rem;
            width: 1.5rem;
            text-align: center;
        }

        .nav-sidebar .nav-link p {
            margin: 0;
            font-weight: 500;
            flex-grow: 1;
        }

        .nav-sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(3px);
        }

        .nav-sidebar .nav-link.active {
            background-color: #843674;
            color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .nav-treeview {
            display: none;
            list-style: none;
            padding: 0.5rem 0 0.5rem 2.5rem;
        }

        /* Mostrar submenu quando o item pai tem a classe menu-open */
        .nav-item.menu-open > .nav-treeview {
            display: block;
        }

        .nav-treeview .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            margin-left: 0;
        }

        /* Estilo específico para links ativos nos submenus */
        .nav-treeview .nav-link.active {
            background-color: transparent;
            color: #c2c7d0;
            box-shadow: none;
        }

        /* Apenas o ícone (bolinha) fica colorido quando ativo */
        .nav-treeview .nav-link.active i.nav-icon {
            color: var(--bs-primary);
        }

        .nav-treeview .nav-link.active {
            border-left-color: var(--bs-primary);
        }

        .nav-link .right {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .nav-item.menu-open > .nav-link .right {
            transform: rotate(-90deg);
        }

        .nav-header {
            color: #6c757d;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            padding: 1rem 0.75rem 0.5rem 1.5rem;
            letter-spacing: 0.05rem;
        }

        .user-panel {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }
        
        .user-panel .image img {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
        
        .user-panel .info {
            padding-left: 0.75rem;
        }
        
        .user-panel .info a {
            color: #fff;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        
        .user-panel .info a:hover {
            color: var(--bs-primary);
            text-decoration: none;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializa os menus com um item ativo
            const activeItems = document.querySelectorAll('.nav-item:not(.menu-open) .nav-link.active');
            activeItems.forEach(item => {
                // Encontra o item pai e adiciona a classe menu-open
                const parentItem = item.closest('.nav-item').parentElement;
                if (parentItem && parentItem.classList.contains('nav-treeview')) {
                    const menuItem = parentItem.closest('.nav-item');
                    if (menuItem) {
                        menuItem.classList.add('menu-open');
                    }
                }
            });

            // Inicializa os elementos de menu para abrir/fechar submenus
            const menuLinks = document.querySelectorAll('.nav-sidebar .nav-item > .nav-link:not(:only-child)');
            menuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Encontra o item de menu pai
                    const parentItem = this.parentElement;
                    
                    // Toggle da classe menu-open
                    parentItem.classList.toggle('menu-open');
                });
            });
        });
    </script>
</aside>
