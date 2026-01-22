@extends('layouts.admin')

@section('title', 'Edit Service - Pxp3 Admin')

@section('header', 'Edit Service')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-server me-2 text-tertiary"></i>
                    Edit Service: {{ $service->title }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Service Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-white @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $service->title) }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price (Optional)</label>
                            <input type="number" step="0.01" class="form-control bg-white @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $service->price) }}">
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="price_period" class="form-label">Price Period (Optional)</label>
                            <select class="form-select bg-white @error('price_period') is-invalid @enderror" id="price_period" name="price_period">
                                <option value="">No period</option>
                                <option value="hour" {{ old('price_period', $service->price_period) == 'hour' ? 'selected' : '' }}>Per Hour</option>
                                <option value="day" {{ old('price_period', $service->price_period) == 'day' ? 'selected' : '' }}>Per Day</option>
                                <option value="week" {{ old('price_period', $service->price_period) == 'week' ? 'selected' : '' }}>Per Week</option>
                                <option value="month" {{ old('price_period', $service->price_period) == 'month' ? 'selected' : '' }}>Per Month</option>
                                <option value="year" {{ old('price_period', $service->price_period) == 'year' ? 'selected' : '' }}>Per Year</option>
                                <option value="project" {{ old('price_period', $service->price_period) == 'project' ? 'selected' : '' }}>Per Project</option>
                            </select>
                            @error('price_period')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description <span class="text-danger">*</span></label>
                        <textarea class="form-control bg-white @error('short_description') is-invalid @enderror" id="short_description" name="short_description" rows="2" required>{{ old('short_description', $service->short_description) }}</textarea>
                        @error('short_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Full Description <span class="text-danger">*</span></label>
                        <textarea class="form-control bg-white @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description', $service->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Service Image</label>
                        @if($service->image_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                        @endif
                        <input type="file" class="form-control bg-white @error('image') is-invalid @enderror" id="image" name="image">
                        <div class="form-text">Leave empty to keep the current image. Recommended size: 1200x800px (JPG, PNG)</div>
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cta_text" class="form-label">Call-to-Action Text</label>
                        <input type="text" class="form-control bg-white @error('cta_text') is-invalid @enderror" id="cta_text" name="cta_text" value="{{ old('cta_text', $service->cta_text) }}">
                        @error('cta_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cta_url" class="form-label">Call-to-Action URL</label>
                        <input type="url" class="form-control bg-white @error('cta_url') is-invalid @enderror" id="cta_url" name="cta_url" value="{{ old('cta_url', $service->cta_url) }}">
                        <div class="form-text">Leave empty to use the contact page</div>
                        @error('cta_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Features/Highlights</label>
                        <div class="highlights-container mb-3">
                            @php
                                $highlights = old('highlights', json_decode($service->highlights) ?: []);
                            @endphp
                            
                            @if(count($highlights) > 0)
                                @foreach($highlights as $index => $highlight)
                                    <div class="highlight-item mb-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-white @error('highlights.'.$index) is-invalid @enderror" 
                                                   name="highlights[]" value="{{ $highlight }}" placeholder="Add a service highlight">
                                            <button type="button" class="btn btn-outline-danger remove-highlight" 
                                                    {{ $loop->first && $loop->count == 1 ? 'style=display:none;' : '' }}>
                                                <i class="fas fa-times"></i>
                                            </button>
                                            @error('highlights.'.$index)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="highlight-item mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white" name="highlights[]" 
                                               placeholder="Add a service highlight">
                                        <button type="button" class="btn btn-outline-danger remove-highlight" style="display: none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="add-highlight">
                            <i class="fas fa-plus"></i> Add Feature
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label">Display Order</label>
                        <input type="number" class="form-control bg-white @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $service->order) }}">
                        <div class="form-text">Lower numbers appear first</div>
                        @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input bg-white" type="checkbox" id="featured" name="featured" value="1" {{ old('featured', $service->featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                Featured Service
                            </label>
                            <div class="form-text">Featured services appear in the homepage and are highlighted in the services listing</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select bg-white @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="draft" {{ old('status', $service->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $service->status) == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-info-circle me-2 text-tertiary"></i>
                    Tips
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="fw-bold">Creating Effective Services</h6>
                    <ul class="text-muted mb-0">
                        <li>Be clear and specific about what the service includes</li>
                        <li>Use concise, benefit-focused descriptions</li>
                        <li>Highlight what makes your service unique</li>
                        <li>Add features that resonate with your target audience</li>
                        <li>Include high-quality images that represent the service</li>
                    </ul>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Pro Tip:</strong> Featured services appear on the homepage and in prominent positions throughout the site.
                </div>
            </div>
        </div>

        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-danger bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold text-danger">
                    <i class="fas fa-trash-alt me-2"></i>
                    Danger Zone
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Permanently delete this service and all of its data.</p>
                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fas fa-trash-alt me-2"></i> Delete Service
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Service Highlights
        const highlightsContainer = document.querySelector('.highlights-container');
        const addHighlightBtn = document.getElementById('add-highlight');
        
        addHighlightBtn.addEventListener('click', function() {
            const highlightItem = document.createElement('div');
            highlightItem.className = 'highlight-item mb-2';
            highlightItem.innerHTML = `
                <div class="input-group">
                    <input type="text" class="form-control bg-white" name="highlights[]" placeholder="Add a service highlight">
                    <button type="button" class="btn btn-outline-danger remove-highlight"><i class="fas fa-times"></i></button>
                </div>
            `;
            highlightsContainer.appendChild(highlightItem);
            
            // Show remove button on the first item if there are multiple items
            const removeButtons = document.querySelectorAll('.remove-highlight');
            if (removeButtons.length > 1) {
                removeButtons.forEach(button => {
                    button.style.display = 'block';
                });
            }
        });
        
        // Remove highlight
        highlightsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-highlight') || e.target.parentElement.classList.contains('remove-highlight')) {
                const button = e.target.classList.contains('remove-highlight') ? e.target : e.target.parentElement;
                const highlightItem = button.closest('.highlight-item');
                highlightItem.remove();
                
                // Hide remove button on the first item if only one remains
                const removeButtons = document.querySelectorAll('.remove-highlight');
                if (removeButtons.length === 1) {
                    removeButtons[0].style.display = 'none';
                }
            }
        });
    });
</script>
@endsection 