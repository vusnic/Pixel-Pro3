@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">Edit Category</h1>
                    <div>
                        <a href="{{ route('blog', ['category' => $category->slug]) }}" class="btn btn-outline-secondary me-2"
                            target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>View on Site
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name *</label>
                                        <input type="text"
                                            class="form-control text-theme-secondary @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $category->name) }}"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control text-theme-secondary @error('description') is-invalid @enderror" id="description"
                                            name="description" rows="4" placeholder="Briefly describe what this category covers...">{{ old('description', $category->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Save Changes
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
                                    <h6>Current Slug</h6>
                                    <p class="text-muted small">
                                        <code>{{ $category->slug }}</code>
                                    </p>
                                    <p class="text-muted small">The slug will be automatically updated if you change the
                                        category name.</p>
                                </div>
                                <div class="mb-3">
                                    <h6>URL</h6>
                                    <p class="text-muted small">The category is available at: <br>
                                        <code>{{ url('/blog?category=' . $category->slug) }}</code>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Statistics</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <strong>{{ $category->posts()->count() }}</strong>
                                        </div>
                                        <small class="text-muted">Posts in this category</small>
                                    </div>
                                </div>
                                <hr>
                                <div class="small text-muted">
                                    <div><strong>Criado:</strong> {{ $category->created_at->format('d/m/Y H:i') }}</div>
                                    <div><strong>Atualizado:</strong> {{ $category->updated_at->format('d/m/Y H:i') }}
                                    </div>
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

            nameInput.addEventListener('input', function() {
                const slug = this.value.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');

                // Update slug preview if available
                const slugPreview = document.getElementById('slug-preview');
                if (slugPreview) {
                    slugPreview.textContent = slug || 'category-slug';
                }
            });
        });
    </script>
@endsection
