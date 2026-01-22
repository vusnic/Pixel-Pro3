@extends('layouts.admin')

@section('title', 'Edit Post')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Edit Post</h1>
                <div>
                    <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-outline-secondary me-2" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>View on Site
                    </a>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.blog.update', $post->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title *</label>
                                    <input type="text" 
                                           class="form-control text-theme-secondary @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $post->title) }}" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Excerpt *</label>
                                    <textarea class="form-control text-theme-secondary @error('excerpt') is-invalid @enderror" 
                                              id="excerpt" 
                                              name="excerpt" 
                                              rows="3" 
                                              required>{{ old('excerpt', $post->excerpt) }}</textarea>
                                    @error('excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Content *</label>
                                    <textarea class="form-control text-theme-secondary @error('content') is-invalid @enderror" 
                                              id="content" 
                                              name="content" 
                                              rows="15" 
                                              required>{{ old('content', $post->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cover_image" class="form-label">Cover Image</label>
                                    @if($post->cover_image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $post->cover_image) }}" 
                                                 alt="Imagem atual" 
                                                 class="img-thumbnail" 
                                                 style="max-width: 200px;">
                                            <small class="form-text text-muted d-block">Imagem atual</small>
                                        </div>
                                    @endif
                                    <input type="file" 
                                           class="form-control @error('cover_image') is-invalid @enderror" 
                                           id="cover_image" 
                                           name="cover_image" 
                                           accept="image/*">
                                    @error('cover_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Deixe em branco para manter a imagem atual</small>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Section -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">SEO</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" 
                                           class="form-control text-theme-secondary @error('meta_title') is-invalid @enderror" 
                                           id="meta_title" 
                                           name="meta_title" 
                                           value="{{ old('meta_title', $post->meta_title) }}">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control text-theme-secondary @error('meta_description') is-invalid @enderror" 
                                              id="meta_description" 
                                              name="meta_description" 
                                              rows="3">{{ old('meta_description', $post->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select text-theme-secondary @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        @php
                                            $currentStatus = 'draft';
                                            if ($post->published) {
                                                if ($post->published_at && $post->published_at <= now()) {
                                                    $currentStatus = 'published';
                                                } else {
                                                    $currentStatus = 'scheduled';
                                                }
                                            }
                                        @endphp
                                        <option value="draft" {{ old('status', $currentStatus) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $currentStatus) == 'published' ? 'selected' : '' }}>Published</option> 
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" id="published_at_field" style="display: none;">
                                    <label for="published_at" class="form-label">Publication Date</label>
                                    <input type="datetime-local" 
                                           class="form-control text-theme-secondary @error('published_at') is-invalid @enderror" 
                                           id="published_at" 
                                           name="published_at" 
                                           value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category *</label>
                                    <select class="form-select text-theme-secondary @error('category_id') is-invalid @enderror" 
                                            id="category_id" 
                                            name="category_id" 
                                            required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags</label>
                                    <select class="form-select text-theme-secondary @error('tags') is-invalid @enderror" 
                                            id="tags" 
                                            name="tags[]" 
                                            multiple>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}" 
                                                    {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Hold Ctrl to select multiple tags</small>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Estatísticas</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="mb-2">
                                            <strong>{{ number_format($post->views) }}</strong>
                                        </div>
                                        <small class="text-muted">Visualizações</small>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-2">
                                            <strong>{{ $post->tags->count() }}</strong>
                                        </div>
                                        <small class="text-muted">Tags</small>
                                    </div>
                                </div>
                                <hr>
                                <div class="small text-muted">
                                    <div><strong>Created:</strong> {{ $post->created_at->format('d/m/Y H:i') }}</div>
                                    <div><strong>Updated:</strong> {{ $post->updated_at->format('d/m/Y H:i') }}</div>
                                    <div><strong>Author:</strong> {{ $post->user->name }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Changes
                                    </button>
                                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const publishedAtField = document.getElementById('published_at_field');
    
    function togglePublishedAtField() {
        if (statusSelect.value === 'scheduled') {
            publishedAtField.style.display = 'block';
        } else {
            publishedAtField.style.display = 'none';
        }
    }
    
    statusSelect.addEventListener('change', togglePublishedAtField);
    togglePublishedAtField(); // Run on page load
});
</script>
@endsection 