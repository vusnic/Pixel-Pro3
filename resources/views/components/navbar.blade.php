<!-- Navbar Desktop (visível em lg) -->
<nav id="navScroll" class="navbar navbar-dark bg-theme-primary fixed-top px-vw-5 d-none d-lg-block" tabindex="0">
  <div class="container">
    <a href="{{ route('home') }}">
      <img src="{{ asset('img/nav-brand-logo.svg') }}" alt="Pxp3 Logo" class="fw-bolder navLogo"
        style="height: 30px!important; width:137.4px!important;">
    </a>
    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 list-group list-group-horizontal">
      <li class="nav-item">
        <a class="nav-link fs-5 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" aria-label="Homepage">
          Home
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link fs-5 {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}" aria-label="Our Services">
          Services
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link fs-5 {{ request()->routeIs('portfolio') ? 'active' : '' }}" href="{{ route('portfolio') }}" aria-label="Our Portfolio">
          Portfolio
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link fs-5" href="https://www.shop.pixelpro3.com/" aria-label="Shop">
          Shop
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link fs-5 {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}" aria-label="Contact Us">
          Contact
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link fs-5 {{ request()->routeIs('blog') ? 'active' : '' }}" href="{{ route('blog') }}" aria-label="Blog">
          Blog
        </a>
      </li>
    </ul>
    <a href="#" aria-label="Download this template" class="btn btn-outline-light me-3">
      <small>Get a Quote</small>
    </a>
    <a href="#" type="button" class="btn btn-outline-light ms-2" id="themeSwitcher">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half"
        viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
      </svg>
    </a>
  </div>
</nav>

<!-- Navbar Mobile (visível em sm) -->
<nav class="navbar navbar-dark bg-theme-primary fixed-top d-block d-lg-none">
  <div class="container-fluid">
    <a href="{{ route('home') }}">
      <img src="{{ asset('img/nav-brand-logo.svg') }}" alt="Pxp3 Logo" class="ms-5 fw-bolder navLogo"
        style="height: 30px; width:137.4px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
      aria-controls="offcanvasDarkNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-theme-secondary bg-theme-primary" tabindex="-1"
      id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <a href="{{ route('home') }}">
          <img src="{{ asset('img/nav-brand-logo.svg') }}" alt="Pxp3 Logo" class="fw-bolder navLogo"
            style="height: 30px; width:137.4px;">
        </a>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
          aria-label="Fechar"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('portfolio') ? 'active' : '' }}" href="{{ route('portfolio') }}">Portfolio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.shop.pixelpro3.com/">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}" href="{{ route('blog') }}">Blog</a>
          </li>
        </ul>
        <div class="mt-3">
          <a href="#" class="btn btn-outline-light border-light me-3">
            <small>Get a Quote</small>
          </a>
          <a href="#" class="btn btn-outline-light border-light" id="themeSwitcherMobile">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              class="bi bi-circle-half" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</nav> 