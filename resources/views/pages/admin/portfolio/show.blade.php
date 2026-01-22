@extends('layouts.admin')

@section('title', 'View Project - Pxp3 Admin')

@section('header', 'View Project')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index') }}">Portfolio</a></li>
<li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card rounded-5 border-0 shadow-lg">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-image me-2 text-tertiary"></i>
                        Project Details
                    </h5>
                    <a href="{{ route('admin.portfolio.edit', $portfolio->id) }}" class="btn btn-sm btn-primary rounded-4">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <h4 class="mb-3">{{ $portfolio->title }}</h4>
                
                @if($portfolio->image_path)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="img-fluid rounded-4" style="max-height: 250px;">
                </div>
                @endif
                
                <div class="mb-3">
                    <h6 class="fw-bold">Status</h6>
                    @if($portfolio->status === 'published')
                    <span class="badge bg-success rounded-pill px-3 py-2">Published</span>
                    @else
                    <span class="badge bg-secondary rounded-pill px-3 py-2">Draft</span>
                    @endif
                    
                    @if($portfolio->featured)
                    <span class="badge bg-warning rounded-pill px-3 py-2 ms-2">Featured</span>
                    @endif
                </div>
                
                <div class="mb-3">
                    <h6 class="fw-bold">Category</h6>
                    <span class="badge bg-secondary rounded-pill px-3 py-2">
                        <i class="fas fa-folder me-1"></i>
                        {{ ucfirst($portfolio->category) }}
                    </span>
                </div>
                
                @if($portfolio->client_name)
                <div class="mb-3">
                    <h6 class="fw-bold">Client</h6>
                    <p class="mb-0">{{ $portfolio->client_name }}</p>
                </div>
                @endif
                
                @if($portfolio->completion_date)
                <div class="mb-3">
                    <h6 class="fw-bold">Completion Date</h6>
                    <p class="mb-0">
                        <i class="fas fa-calendar text-tertiary me-2"></i>
                        {{ $portfolio->completion_date->format('F d, Y') }}
                    </p>
                </div>
                @endif
                
                @if($portfolio->project_url)
                <div class="mb-3">
                    <h6 class="fw-bold">Project URL</h6>
                    <a href="{{ $portfolio->project_url }}" target="_blank" class="text-decoration-none d-flex align-items-center">
                        <i class="fas fa-globe text-tertiary me-2"></i>
                        {{ $portfolio->project_url }}
                    </a>
                </div>
                @endif
                
                @if($portfolio->technologies)
                <div class="mb-3">
                    <h6 class="fw-bold">Technologies</h6>
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($portfolio->getTechnologiesArrayAttribute() as $tech)
                            <span class="badge bg-secondary rounded-pill">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="mb-3">
                    <h6 class="fw-bold">Display Order</h6>
                    <p class="mb-0">
                        <i class="fas fa-sort text-tertiary me-2"></i>
                        {{ $portfolio->order }}
                    </p>
                </div>
                
                <div class="mb-3">
                    <h6 class="fw-bold">Created</h6>
                    <p class="mb-1">{{ $portfolio->created_at->format('F d, Y h:i A') }}</p>
                    <p class="mb-0 text-muted">{{ $portfolio->created_at->diffForHumans() }}</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="fw-bold">Last Updated</h6>
                    <p class="mb-1">{{ $portfolio->updated_at->format('F d, Y h:i A') }}</p>
                    <p class="mb-0 text-muted">{{ $portfolio->updated_at->diffForHumans() }}</p>
                </div>
                
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-secondary rounded-4">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                    <a href="{{ route('admin.portfolio.edit', $portfolio->id) }}" class="btn btn-outline-primary rounded-4">
                        <i class="fas fa-edit me-1"></i> Editar
                    </a>
                    <a href="{{ route('portfolio.show', $portfolio->id) }}" class="btn btn-outline-info rounded-4" target="_blank">
                        <i class="fas fa-eye me-1"></i> Visualizar
                    </a>
                    <form action="{{ route('admin.portfolio.destroy', $portfolio->id) }}" method="POST" class="m-0" onsubmit="return confirm('Tem certeza que deseja excluir este projeto?');">
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
                    Project Content
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <h6 class="fw-bold">Description</h6>
                    <div class="p-4 bg-light bg-opacity-10 rounded-4 text-light">
                        {!! nl2br(e($portfolio->description)) !!}
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">Features/Highlights</h6>
                    @if($portfolio->highlights && count(json_decode($portfolio->highlights)) > 0)
                    <div class="row row-cols-1 row-cols-md-2 g-3">
                        @foreach(json_decode($portfolio->highlights) as $highlight)
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
                        No features/highlights added to this project.
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-chart-line me-2 text-tertiary"></i>
                    Project Analytics
                </h5>
            </div>
            <div class="card-body text-center py-5">
                <div class="d-inline-block p-4 bg-light bg-opacity-10 rounded-4 mb-3">
                    <i class="fas fa-chart-bar fa-3x text-tertiary"></i>
                </div>
                <h4>Analytics Coming Soon</h4>
                <p class="text-muted mb-0">Project view statistics and analytics will be available in a future update.</p>
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