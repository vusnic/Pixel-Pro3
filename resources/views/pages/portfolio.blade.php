@extends('layouts.app')

@section('title', 'Pxp3 - Portfolio')

@section('content')
    <div class="w-100 overflow-hidden position-relative bg-theme-primary text-theme-primary" data-aos="fade">
        <div class="position-absolute w-100 h-100 bg-theme-primary opacity-75 top-0 start-0"></div>
        <div class="container py-vh-4 position-relative mt-5 px-vw-5 text-center">
            <div class="row d-flex align-items-center justify-content-center py-vh-5">
                <div class="col-12 col-xl-10">
                    <h1 class="display-huge mt-3 mb-3 lh-1 fw-bold">Our Portfolio</h1>
                </div>
                <div class="col-12 col-xl-10">
                    <p class="lead text-theme-secondary mb-4">Check out some of the projects we've developed with dedication and excellence.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtro por categorias -->
    @if($categories->count() > 0)
    <div class="bg-dark py-vh-2">
        <div class="container px-vw-5">
            <div class="row">
                <div class="col-12">
                    <div class="portfolio-filters text-center">
                        <a href="{{ route('portfolio') }}" class="btn btn-outline-light mb-2 {{ !request()->has('category') ? 'active' : '' }}">All</a>
                        @foreach($categories as $category)
                            <a href="{{ route('portfolio', ['category' => $category]) }}" 
                               class="btn btn-outline-light mb-2 {{ request('category') == $category ? 'active' : '' }}">
                                {{ ucfirst($category) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-dark py-vh-5">
        <div class="container px-vw-5">
            <div class="row d-flex gx-5 gy-5">
                @forelse ($portfolios as $portfolio)
                <!-- Project {{ $loop->iteration }} -->
                <div class="col-12 col-md-6 col-xl-4" data-aos="zoom-in-up" data-aos-delay="{{ $loop->index * 200 % 600 }}">
                    <div class="card bg-transparent card-hover">
                        <div class="bg-dark rounded-5 p-0">
                            @if($portfolio->image_path)
                                <img src="{{ asset('storage/' . $portfolio->image_path) }}" class="img-fluid rounded-5 no-bottom-radius service-card-img" alt="{{ $portfolio->title }}">
                            @else
                                <img src="{{ asset('img/webp/abstract9.webp') }}" class="img-fluid rounded-5 no-bottom-radius service-card-img" alt="{{ $portfolio->title }}">
                            @endif
                            <div class="p-4 p-md-5 p-lg-6">
                                <h3 class="fw-lighter">{{ $portfolio->title }}</h3>
                                <p class="text-theme-secondary pb-3">{{ Str::limit($portfolio->description, 100) }}</p>
                                <a href="{{ route('portfolio.show', $portfolio->id) }}" class="link-fancy link-fancy-light">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center" data-aos="fade-up">
                    <div class="alert bg-dark text-theme-secondary p-5 rounded-5">
                        <h3 class="fw-lighter mb-3">No projects found</h3>
                        <p>We're currently updating our portfolio. Please check back soon!</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Paginação -->
            @if($portfolios->count() > 0 && $portfolios->hasPages())
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $portfolios->links('components.pagination') }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="bg-theme-primary py-vh-5">
        <div class="container px-vw-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-10 text-center">
                    <h2 class="display-5 text-tertiary">Want to have a project like these?</h2>
                    <p class="lead text-theme-secondary">
                        Let's transform your idea into a successful project. Contact us and request a personalized quote.
                    </p>
                    <div class="col-12 text-center mt-5">
                        <a href="{{ route('contact') }}" class="btn btn-xl bg-tertiary d-inline-flex align-items-center">
                            <span>Contact Us</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 