@extends('layouts.admin')

@section('title', 'New Tag')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">New Tag</h1>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.tags.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tag Name *</label>
                                    <input type="text" 
                                           class="form-control text-theme-secondary @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="Ex: Laravel, PHP, JavaScript..."
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Use short and specific names for better organization</small>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Tag
                                    </button>
                                    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Informações sobre Tags</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6>Slug</h6>
                                <p class="text-muted small">O slug será gerado automaticamente baseado no nome da tag. Por exemplo: "JavaScript" se tornará "javascript".</p>
                            </div>
                            <div class="mb-3">
                                <h6>Uso</h6>
                                <p class="text-muted small">As tags ajudam a categorizar posts com mais granularidade, permitindo aos usuários encontrar conteúdo relacionado.</p>
                            </div>
                            <div class="mb-3">
                                <h6>Boas Práticas</h6>
                                <ul class="text-muted small">
                                    <li>Use nomes curtos e específicos</li>
                                    <li>Evite plural desnecessário</li>
                                    <li>Mantenha consistência na nomenclatura</li>
                                    <li>Reutilize tags existentes quando possível</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 