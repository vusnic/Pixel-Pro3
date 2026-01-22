@extends('layouts.admin')

@section('title', 'New Category')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">New Category</h1>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.categories.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name *</label>
                                    <input type="text" 
                                           class="form-control text-theme-secondary @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control text-theme-secondary @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Briefly describe what this category covers...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Category
                                    </button>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
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
                            <h5 class="mb-0">Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6>Slug</h6>
                                <p class="text-muted small">The slug will be automatically generated based on the category name. For example: "Web Development" will become "web-development".</p>
                            </div>
                            <div class="mb-3">
                                <h6>Usage</h6>
                                <p class="text-muted small">Categories help organize blog posts and allow visitors to filter content by topics of interest.</p>
                            </div>
                            <div class="mb-3">
                                <h6>URL</h6>
                                <p class="text-muted small">The category will be available at: <br>
                                <code>{{ url('/blog?category=') }}<span id="slug-preview">category-slug</span></code></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugPreview = document.getElementById('slug-preview');
    
    nameInput.addEventListener('input', function() {
        const slug = this.value.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        
        slugPreview.textContent = slug || 'category-slug';
    });
});
</script>
@endsection 