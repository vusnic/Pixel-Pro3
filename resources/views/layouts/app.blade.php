<!DOCTYPE html>
<html class="h-100" lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    
    <!-- SEO Component -->
    <x-seo 
        :title="$title ?? 'Pxp3'"
        :description="$description ?? ''" 
        :keywords="$keywords ?? ''" 
        :image="$image ?? ''" 
        :type="$type ?? 'website'" 
        :url="$url ?? ''"
    />
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/pixelpro3logo-trans.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/pixelpro3logo-trans.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/pixelpro3logo-trans.png') }}">
    
    <meta name="generator" content="Laravel v{{ Illuminate\Foundation\Application::VERSION }}">
    <meta name="HandheldFriendly" content="true">
    
    <!-- Preload Critical Resources -->
    <link rel="preload" href="{{ asset('css/aos.css') }}" as="style">
    <link rel="preload" href="{{ asset('js/bootstrap.bundle.min.js') }}" as="script">
    <link rel="preload" href="{{ asset('js/aos.js') }}" as="script">
    
    <!-- Google Analytics - Only load on non-admin pages -->
    <script>
        // Verificar se a URL começa com /admin
        if (window.location.pathname.startsWith('/admin')) {
          // Desabilitar o rastreamento do Google Analytics
          window['ga-disable-G-6BPSV5KJDE'] = true;
        }
    </script>
    <!-- Google tag (gtag.js) - Load asynchronously -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6BPSV5KJDE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-6BPSV5KJDE');
    </script>

    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-theme-primary text-theme-primary mt-0" data-bs-spy="scroll" data-bs-target="#navScroll">
    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <!-- Load non-critical scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('js/aos.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js" defer></script>

    <!-- Particles.js - Load only when needed with lazy loading -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // If particles-js container exists on the page
            if (document.getElementById('particles-js')) {
                // Load particles.js script dynamically
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js';
                script.onload = function() {
                    console.log('Initializing particles.js directly from layout');

                    // Clear any previous initialization
                    if (window.pJSDom && window.pJSDom.length > 0) {
                        console.log('Clearing previous particles.js initializations');
                        window.pJSDom = [];
                    }

                    // Particles.js configuration
                    var config = {
                        "particles": {
                            "number": {
                                "value": 80,
                                "density": {
                                    "enable": true,
                                    "value_area": 1800
                                }
                            },
                            "color": {
                                "value": ["#e230c6", "#b31abb", "#8f15b0", "#6d0fa5"]
                            },
                            "shape": {
                                "type": "circle",
                                "stroke": {
                                    "width": 0,
                                    "color": "#000000"
                                }
                            },
                            "opacity": {
                                "value": 0.8,
                                "random": true,
                                "anim": {
                                    "enable": true,
                                    "speed": 0.5,
                                    "opacity_min": 0.4,
                                    "sync": false
                                }
                            },
                            "size": {
                                "value": 2.5,
                                "random": true,
                                "anim": {
                                    "enable": true,
                                    "speed": 1,
                                    "size_min": 1,
                                    "sync": false
                                }
                            },
                            "line_linked": {
                                "enable": true,
                                "distance": 120,
                                "color": "#e230c6",
                                "opacity": 0.5,
                                "width": 1.2
                            },
                            "move": {
                                "enable": true,
                                "speed": 0.8,
                                "direction": "none",
                                "random": true,
                                "straight": false,
                                "out_mode": "out",
                                "bounce": false,
                                "attract": {
                                    "enable": true,
                                    "rotateX": 800,
                                    "rotateY": 800
                                }
                            }
                        },
                        "interactivity": {
                            "detect_on": "window",
                            "events": {
                                "onhover": {
                                    "enable": true,
                                    "mode": "grab"
                                },
                                "onclick": {
                                    "enable": true,
                                    "mode": "repulse"
                                },
                                "resize": true
                            },
                            "modes": {
                                "grab": {
                                    "distance": 180,
                                    "line_linked": {
                                        "opacity": 0.8
                                    }
                                },
                                "repulse": {
                                    "distance": 150,
                                    "duration": 0.8
                                }
                            }
                        },
                        "retina_detect": true
                    };

                    // Initialize
                    particlesJS('particles-js', config);

                    // Verification and correction function
                    var fixParticles = function() {
                        console.log('Checking and fixing particles.js');

                        // Force events on canvas
                        var canvas = document.querySelector('#particles-js canvas');
                        if (canvas) {
                            // Ensure canvas can capture events
                            canvas.style.position = 'absolute';
                            canvas.style.top = '0';
                            canvas.style.left = '0';
                            canvas.style.width = '100%';
                            canvas.style.height = '100%';
                            canvas.style.pointerEvents = 'auto';
                            canvas.style.zIndex = '9';

                            // Check if canvas is receiving events
                            if (!canvas.getAttribute('data-events-added')) {
                                canvas.setAttribute('data-events-added', 'true');
                            }
                        }
                    };

                    // Wait for particles to initialize
                    setTimeout(fixParticles, 500);
                };
                document.body.appendChild(script);
            }
        });
    </script>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
</body>

</html>
