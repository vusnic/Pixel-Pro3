@extends('layouts.app')

@section('title', $service->title . ' - Pxp3')

@section('content')
    <div class="w-100 overflow-hidden position-relative bg-theme-primary text-theme-primary" data-aos="fade">
        <div class="position-absolute w-100 h-100 bg-theme-primary opacity-75 top-0 start-0"></div>
        <div class="container py-vh-4 position-relative mt-5 px-vw-5 text-center">
            <div class="row d-flex align-items-center justify-content-center py-vh-5">
                <div class="col-12 col-xl-10">
                    <h1 class="display-huge mt-3 mb-3 lh-1 fw-bold">{{ $service->title }}</h1>
                </div>
                @if($service->price)
                <div class="col-12 col-xl-8">
                    <div class="py-3 text-center">
                        <span class="display-5 fw-bold text-tertiary">{{ number_format($service->price, 2) }}</span>
                        @if($service->price_period)
                        <span class="text-theme-secondary ms-1">/ {{ $service->price_period }}</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-dark py-vh-5">
        <div class="container px-vw-5">
            <div class="row gx-5">
                <!-- Service Details -->
                <div class="col-lg-8 mb-5">
                    @if($service->image_path)
                    <div class="rounded-5 mb-5 overflow-hidden" data-aos="fade-up">
                        <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="img-fluid">
                    </div>
                    @endif
                    
                    <div class="mb-5" data-aos="fade-up">
                        <h2 class="mb-4 fw-lighter">About This Service</h2>
                        <div class="text-theme-secondary">
                            {!! nl2br(e($service->description)) !!}
                        </div>
                    </div>
                    
                    @if($service->highlights && json_decode($service->highlights))
                    <div class="mb-5" data-aos="fade-up">
                        <h3 class="mb-4 fw-lighter">Key Features</h3>
                        <div class="row">
                            @foreach(json_decode($service->highlights) as $highlight)
                            <div class="col-md-6">
                                <div class="d-flex mb-3">
                                    <div class="bg-tertiary text-white rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $highlight }}</h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <div class="mt-5">
                        @if($service->cta_text && $service->cta_url)
                        <a href="{{ $service->cta_url }}" class="btn btn-lg bg-tertiary px-5 py-3 d-inline-flex align-items-center">
                            <span>{{ $service->cta_text }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </a>
                        @else
                        <a href="{{ route('contact') }}" class="btn btn-lg bg-tertiary px-5 py-3 d-inline-flex align-items-center">
                            <span>Get in touch</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card bg-dark rounded-5 p-4 shadow mb-5">
                        <h3 class="border-bottom pb-3 mb-4 fw-lighter">Need Help?</h3>
                        <p class="text-theme-secondary">Have questions about this service or need to customize it for your specific needs?</p>
                        <a href="{{ route('contact') }}" class="btn btn-outline-tertiary d-flex align-items-center justify-content-center">
                            <i class="fas fa-envelope me-2"></i> Contact Us
                        </a>
                    </div>
                    
                    <div class="card bg-dark rounded-5 p-4 shadow">
                        <h3 class="border-bottom pb-3 mb-4 fw-lighter">Other Services</h3>
                        <div class="list-group list-group-flush bg-transparent">
                            @php
                                $otherServices = \App\Models\Service::where('id', '!=', $service->id)
                                    ->where('status', 'published')
                                    ->orderBy('order')
                                    ->limit(5)
                                    ->get();
                            @endphp
                            
                            @forelse($otherServices as $otherService)
                            <a href="{{ route('services.show', $otherService->id) }}" class="list-group-item list-group-item-action px-0 py-3 bg-transparent border-bottom border-secondary text-theme-secondary">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $otherService->title }}</span>
                                    <i class="fas fa-chevron-right text-tertiary"></i>
                                </div>
                            </a>
                            @empty
                            <p class="text-theme-secondary">No other services available.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-theme-primary py-vh-5">
        <div class="container px-vw-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-10 text-center">
                    <h2 class="display-5 text-tertiary">Ready to get started?</h2>
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