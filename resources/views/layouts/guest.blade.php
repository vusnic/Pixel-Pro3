<!DOCTYPE html>
<html class="h-100" lang="en-US">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="description" content="Pxp3 Web Design Agency">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/pixelpro3logo-trans.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/pixelpro3logo-trans.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/pixelpro3logo-trans.png') }}">
    <meta name="author" content="Pxp3 Squad">
    <meta name="generator" content="Laravel v{{ Illuminate\Foundation\Application::VERSION }}">
    <meta name="HandheldFriendly" content="true">
    <title>@yield('title', 'Autenticação - Pxp3')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="d-flex h-100 w-100 bg-black text-white" data-bs-spy="scroll" data-bs-target="#navScroll">
    <div class="h-100 container-fluid">
        <div class="h-100 row d-flex align-items-stretch">
            <div class="col-12 col-md-7 col-lg-6 col-xl-5 d-flex align-items-start flex-column px-vw-5">
                <header class="mb-auto py-vh-2 col-12">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/nav-brand-logo.svg') }}" alt="Pxp3 Logo" class="fw-bolder navLogo"
                          style="height: 30px; width:137.4px;">
                      </a>
                </header>

                <main class="mb-auto col-12">
                    @yield('content')
                </main>
            </div>
            
            <div class="col-12 col-md-5 col-lg-6 col-xl-7 gradient"></div>
        </div>
    </div>
</body>
</html> 