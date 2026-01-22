@extends('layouts.admin')

@section('title', 'Edit Tag')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Edit Tag</h1>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.tags.update', $tag->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tag Name *</label>
                                    <input type="text" 
                                           class="form-control text-theme-secondary @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $tag->name) }}" 
                                           placeholder="Ex: Laravel, PHP, JavaScript..."
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Use short and specific names for better organization</small>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Changes
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
                            <h5 class="mb-0">Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6>Current Slug</h6>
                                <p class="text-muted small">
                                    <code>{{ $tag->slug }}</code>
                                </p>
                                <p class="text-muted small">The slug will be automatically updated if you change the tag name.</p>
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
                                        <strong>{{ $tag->posts()->count() }}</strong>
                                    </div>
                                    <small class="text-muted">Posts with this tag</small>
                                </div>
                            </div>
                            <hr>
                            <div class="small text-muted">
                                <div><strong>Created:</strong> {{ $tag->created_at->format('d/m/Y H:i') }}</div>
                                <div><strong>Updated:</strong> {{ $tag->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 