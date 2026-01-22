@extends('layouts.app')

@section('title', 'Pxp3 - ' . $portfolio->title)

@section('content')
    <div class="w-100 overflow-hidden position-relative bg-theme-primary text-theme-primary" data-aos="fade">
        <div class="position-absolute w-100 h-100 bg-theme-primary opacity-75 top-0 start-0"></div>
        <div class="container py-vh-4 position-relative mt-5 px-vw-5 text-center">
            <div class="row d-flex align-items-center justify-content-center py-5">
                <div class="col-12 col-xl-10">
                    <h1 class="display-huge mt-3 mb-3 lh-1 fw-bold">{{ $portfolio->title }}</h1>
                </div>
                <div class="col-12 col-xl-8">
                    <p class="lead text-theme-secondary mb-4">{{ Str::limit($portfolio->description, 150) }}</p>
                    <div class="d-flex justify-content-center">
                        <span class="badge bg-tertiary me-2">{{ ucfirst($portfolio->category) }}</span>
                        @if($portfolio->completion_date)
                            <span class="badge bg-dark">{{ $portfolio->completion_date->format('M Y') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-dark py-vh-5">
        <div class="container px-vw-5">
            <div class="row gx-5">
                <!-- Imagem do Projeto -->
                <div class="col-12 col-lg-7 mb-5" data-aos="fade-right">
                    <div class="bg-dark p-2 p-md-3 rounded-5 shadow">
                        @if($portfolio->image_path)
                            <img src="{{ asset('storage/' . $portfolio->image_path) }}" class="img-fluid rounded-4" alt="{{ $portfolio->title }}">
                        @else
                            <img src="{{ asset('img/webp/abstract1.webp') }}" class="img-fluid rounded-4" alt="{{ $portfolio->title }}">
                        @endif
                    </div>
                </div>
                
                <!-- Detalhes do Projeto -->
                <div class="col-12 col-lg-5" data-aos="fade-left">
                    <h2 class="display-6 mb-4 text-tertiary">Project Details</h2>
                    
                    <div class="description mb-5">
                        <p>{{ $portfolio->description }}</p>
                    </div>
                    
                    <div class="project-info mb-5">
                        <div class="info-item d-flex mb-3">
                            <div class="info-label text-theme-primary fw-bold" style="width: 130px;">Client:</div>
                            <div class="info-content">{{ $portfolio->client_name ?? 'Not specified' }}</div>
                        </div>
                        
                        <div class="info-item d-flex mb-3">
                            <div class="info-label text-theme-primary fw-bold" style="width: 130px;">Category:</div>
                            <div class="info-content">{{ ucfirst($portfolio->category) }}</div>
                        </div>
                        
                        @if($portfolio->completion_date)
                        <div class="info-item d-flex mb-3">
                            <div class="info-label text-theme-primary fw-bold" style="width: 130px;">Completed:</div>
                            <div class="info-content">{{ $portfolio->completion_date->format('F Y') }}</div>
                        </div>
                        @endif
                        
                        @if($portfolio->project_url)
                        <div class="info-item d-flex mb-3">
                            <div class="info-label text-theme-primary fw-bold" style="width: 130px;">Project URL:</div>
                            <div class="info-content">
                                <a href="{{ $portfolio->project_url }}" target="_blank" class="text-tertiary text-decoration-none">
                                    Visit Site
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-box-arrow-up-right ms-1" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
                                        <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Tecnologias -->
                    @if($portfolio->technologies)
                    <div class="technologies mb-5">
                        <h3 class="fs-4 mb-3 text-theme-primary">Technologies Used</h3>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($portfolio->getTechnologiesArrayAttribute() as $tech)
                                <span class="badge bg-dark border border-tertiary">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Destaques -->
                    @if($portfolio->highlights && is_array($portfolio->highlights) && count($portfolio->highlights) > 0)
                    <div class="highlights mb-5">
                        <h3 class="fs-4 mb-3 text-theme-primary">Project Highlights</h3>
                        <ul class="list-unstyled">
                            @foreach($portfolio->highlights as $highlight)
                                <li class="mb-2">
                                    <div class="d-flex">
                                        <div class="me-2 text-tertiary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                            </svg>
                                        </div>
                                        <div>{{ $highlight }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Projetos Relacionados -->
            @if($related->count() > 0)
            <div class="row mt-7">
                <div class="col-12">
                    <h2 class="display-6 text-center mb-5 text-tertiary" data-aos="fade-up">Related Projects</h2>
                </div>
                
                @foreach($related as $relatedProject)
                <div class="col-12 col-md-6 col-lg-4 mb-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card bg-transparent card-hover">
                        <div class="bg-dark rounded-5 p-0">
                            @if($relatedProject->image_path)
                                <img src="{{ asset('storage/' . $relatedProject->image_path) }}" class="img-fluid rounded-5 no-bottom-radius service-card-img" alt="{{ $relatedProject->title }}">
                            @else
                                <img src="{{ asset('img/webp/abstract' . (($loop->index % 3) + 4) . '.webp') }}" class="img-fluid rounded-5 no-bottom-radius service-card-img" alt="{{ $relatedProject->title }}">
                            @endif
                            <div class="p-4 p-md-4">
                                <h3 class="fs-4 fw-lighter">{{ $relatedProject->title }}</h3>
                                <p class="text-theme-secondary pb-2 small">{{ Str::limit($relatedProject->description, 80) }}</p>
                                <a href="{{ route('portfolio.show', $relatedProject->id) }}" class="link-fancy link-fancy-light">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            
            <!-- Voltar para o portfólio -->
            <div class="row mt-5">
                <div class="col-12 text-center" data-aos="fade-up">
                    <a href="{{ route('portfolio') }}" class="btn btn-outline-light d-inline-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        <span>Back to Portfolio</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-theme-primary py-vh-5">
        <div class="container px-vw-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-10 text-center">
                    <h2 class="display-5 text-tertiary">Want a project like this?</h2>
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