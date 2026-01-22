@extends('layouts.app')

@section('title', 'Pxp3 - Services')

@section('content')
    <div class="w-100 overflow-hidden position-relative bg-theme-primary text-theme-primary" data-aos="fade">
        <div class="position-absolute w-100 h-100 bg-theme-primary opacity-75 top-0 start-0"></div>
        <div class="container py-vh-4 position-relative mt-5 px-vw-5 text-center">
            <div class="row d-flex align-items-center justify-content-center py-vh-5">
                <div class="col-12 col-xl-10">
                    <h1 class="display-huge mt-3 mb-3 lh-1 fw-bold">Our Services</h1>
                </div>
                <div class="col-12 col-xl-10">
                    <p class="lead text-theme-secondary mb-4">Discover our complete digital solutions to boost your business in the online world.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-dark py-vh-5">
        <div class="container px-vw-5">
            <div class="row d-flex gx-5 gy-5">
                @forelse($services as $service)
                <div class="col-12 col-md-6 col-lg-4" data-aos="zoom-in-up" @if(!$loop->first) data-aos-delay="{{ ($loop->index % 3) * 200 }}" @endif>
                    <div class="card bg-transparent border-0 h-100">
                        <div class="bg-dark rounded-5 p-4 p-lg-5 shadow h-100 d-flex flex-column">
                            @if($service->image_path)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $service->image_path) }}" 
                                         alt="{{ $service->title }}" class="img-fluid rounded-4 w-100" 
                                         style="height: 180px; object-fit: cover;">
                                </div>
                            @endif

                            <h3 class="fw-lighter">{{ $service->title }}</h3>
                            
                            @if($service->price)
                                <div class="my-2">
                                    <span class="badge bg-tertiary rounded-pill px-3 py-2 fs-6">
                                        {{ number_format($service->price, 2) }}
                                        @if($service->price_period)
                                            / {{ $service->price_period }}
                                        @endif
                                    </span>
                                    @if($service->featured)
                                        <span class="badge bg-warning rounded-pill px-3 py-2 fs-6 ms-2">Featured</span>
                                    @endif
                                </div>
                            @elseif($service->featured)
                                <div class="my-2">
                                    <span class="badge bg-warning rounded-pill px-3 py-2 fs-6">Featured</span>
                                </div>
                            @endif
                            
                            <p class="text-theme-secondary">{{ $service->short_description }}</p>
                            
                            @if($service->highlights)
                            <ul class="list-unstyled text-theme-secondary mb-4">
                                @foreach(json_decode($service->highlights) as $highlight)
                                <li class="mb-1">
                                    <i class="fas fa-check-circle text-tertiary me-2"></i>
                                    {{ $highlight }}
                                </li>
                                @endforeach
                            </ul>
                            @endif
                            
                            <div class="mt-auto pt-3 d-flex justify-content-between align-items-center">
                                <a href="{{ route('services.show', $service->id) }}" class="link-fancy link-fancy-light">View Details</a>
                                
                                @if($service->cta_text)
                                <a href="{{ $service->cta_url ?? route('contact') }}" class="link-fancy link-fancy-light">{{ $service->cta_text }}</a>
                                @else
                                <a href="{{ route('contact') }}" class="link-fancy link-fancy-light">Request Service</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center" data-aos="fade-up">
                    <div class="alert bg-dark text-theme-secondary p-5 rounded-5">
                        <h3 class="fw-lighter mb-3">No services found</h3>
                        <p>We're currently updating our services. Please check back soon!</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-theme-primary py-vh-5">
        <div class="container px-vw-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-10 text-center">
                    <h2 class="display-5 text-tertiary">Ready to transform your digital business?</h2>
                    <p class="lead text-theme-secondary">
                        Contact us for a free consultation and discover how we can help your company grow in the digital environment.
                    </p>
                    <div class="col-12 text-center mt-5">
                        <a href="{{ route('contact') }}" class="btn btn-xl bg-tertiary d-inline-flex align-items-center">
                            <span>Request a quote</span>
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