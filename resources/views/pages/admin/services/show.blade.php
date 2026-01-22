@extends('layouts.admin')

@section('title', 'View Service - Pxp3 Admin')

@section('header', 'View Service')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></li>
<li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card rounded-5 border-0 shadow-lg">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-server me-2 text-tertiary"></i>
                        Service Details
                    </h5>
                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-primary rounded-4">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <h4 class="mb-3">{{ $service->title }}</h4>
                
                @if($service->image_path)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="img-fluid rounded-4" style="max-height: 250px;">
                </div>
                @endif
                
                <div class="mb-3">
                    <h6 class="fw-bold">Status</h6>
                    @if($service->status === 'published')
                    <span class="badge bg-success rounded-pill px-3 py-2">Published</span>
                    @else
                    <span class="badge bg-secondary rounded-pill px-3 py-2">Draft</span>
                    @endif
                    
                    @if($service->featured)
                    <span class="badge bg-warning rounded-pill px-3 py-2 ms-2">Featured</span>
                    @endif
                </div>
                
                @if($service->price)
                <div class="mb-3">
                    <h6 class="fw-bold">Price</h6>
                    <p class="mb-0">{{ number_format($service->price, 2) }}
                    @if($service->price_period)
                    <span class="text-muted">/ {{ $service->price_period }}</span>
                    @endif
                    </p>
                </div>
                @endif
                
                <div class="mb-3">
                    <h6 class="fw-bold">Display Order</h6>
                    <p class="mb-0">{{ $service->order }}</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="fw-bold">Call-to-Action</h6>
                    @if($service->cta_text)
                    <p class="mb-1">Text: {{ $service->cta_text }}</p>
                    @endif
                    
                    @if($service->cta_url)
                    <p class="mb-0">URL: <a href="{{ $service->cta_url }}" target="_blank" class="text-decoration-none">{{ $service->cta_url }}</a></p>
                    @else
                    <p class="mb-0 text-muted">URL: Using default contact page</p>
                    @endif
                </div>
                
                <div class="mb-3">
                    <h6 class="fw-bold">Created</h6>
                    <p class="mb-1">{{ $service->created_at->format('F d, Y h:i A') }}</p>
                    <p class="mb-0 text-muted">{{ $service->created_at->diffForHumans() }}</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="fw-bold">Last Updated</h6>
                    <p class="mb-1">{{ $service->updated_at->format('F d, Y h:i A') }}</p>
                    <p class="mb-0 text-muted">{{ $service->updated_at->diffForHumans() }}</p>
                </div>
                
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary rounded-4">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-outline-primary rounded-4">
                        <i class="fas fa-edit me-1"></i> Editar
                    </a>
                    <a href="{{ route('services.show', $service->id) }}" class="btn btn-outline-info rounded-4" target="_blank">
                        <i class="fas fa-eye me-1"></i> Visualizar
                    </a>
                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="m-0" onsubmit="return confirm('Tem certeza que deseja excluir este serviço?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger rounded-4">
                            <i class="fas fa-trash me-1"></i> Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-file-alt me-2 text-tertiary"></i>
                    Service Content
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <h6 class="fw-bold">Short Description</h6>
                    <div class="p-4 bg-light bg-opacity-10 rounded-4 text-light">
                        {{ $service->short_description }}
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">Full Description</h6>
                    <div class="p-4 bg-light bg-opacity-10 rounded-4 text-light">
                        {!! nl2br(e($service->description)) !!}
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">Features/Highlights</h6>
                    @if($service->highlights && count(json_decode($service->highlights)) > 0)
                    <div class="row row-cols-1 row-cols-md-2 g-3">
                        @foreach(json_decode($service->highlights) as $highlight)
                        <div class="col">
                            <div class="d-flex align-items-center p-3 bg-light bg-opacity-10 rounded-4">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span class="text-light">{{ $highlight }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="p-4 bg-light bg-opacity-10 rounded-4 text-muted">
                        No features/highlights added to this service.
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-chart-line me-2 text-tertiary"></i>
                    Service Analytics
                </h5>
            </div>
            <div class="card-body text-center py-5">
                <div class="d-inline-block p-4 bg-light bg-opacity-10 rounded-4 mb-3">
                    <i class="fas fa-chart-bar fa-3x text-tertiary"></i>
                </div>
                <h4>Analytics Coming Soon</h4>
                <p class="text-muted mb-0">Service view statistics and analytics will be available in a future update.</p>
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    font-weight: 500;
}

.btn {
    border-radius: 8px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-sm {
    padding: 0.25rem 1rem;
    font-size: 0.875rem;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.img-thumbnail {
    border: 1px solid #dee2e6;
    padding: 0.25rem;
}
</style>
@endsection 