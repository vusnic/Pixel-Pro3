@extends('layouts.admin')

@section('title', 'Add New Project - Pxp3 Admin')

@section('header', 'Add New Project')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index') }}">Portfolio</a></li>
<li class="breadcrumb-item active">Add New</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-plus me-2 text-tertiary"></i>
                    New Project Information
                </h5>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Basic Information -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-info-circle text-tertiary me-2"></i>
                                    Basic Information
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Project Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white @error('title') is-invalid @enderror" 
                                                   id="title" name="title" value="{{ old('title') }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                            <select class="form-select bg-white @error('category') is-invalid @enderror" 
                                                    id="category" name="category" required>
                                                <option value="">Select a category</option>
                                                <option value="web" {{ old('category') == 'web' ? 'selected' : '' }}>Web Development</option>
                                                <option value="mobile" {{ old('category') == 'mobile' ? 'selected' : '' }}>Mobile App</option>
                                                <option value="ui-ux" {{ old('category') == 'ui-ux' ? 'selected' : '' }}>UI/UX Design</option>
                                                <option value="branding" {{ old('category') == 'branding' ? 'selected' : '' }}>Branding</option>
                                                <option value="ecommerce" {{ old('category') == 'ecommerce' ? 'selected' : '' }}>E-commerce</option>
                                                <option value="cms" {{ old('category') == 'cms' ? 'selected' : '' }}>CMS</option>
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="client_name" class="form-label">Client Name</label>
                                            <input type="text" class="form-control bg-white @error('client_name') is-invalid @enderror" 
                                                   id="client_name" name="client_name" value="{{ old('client_name') }}">
                                            @error('client_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="completion_date" class="form-label">Completion Date</label>
                                            <input type="date" class="form-control bg-white @error('completion_date') is-invalid @enderror" 
                                                   id="completion_date" name="completion_date" value="{{ old('completion_date') }}">
                                            @error('completion_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="project_url" class="form-label">Project URL</label>
                                            <input type="url" class="form-control bg-white @error('project_url') is-invalid @enderror" 
                                                   id="project_url" name="project_url" value="{{ old('project_url') }}" 
                                                   placeholder="https://">
                                            @error('project_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="technologies" class="form-label">Technologies</label>
                                            <input type="text" class="form-control bg-white @error('technologies') is-invalid @enderror" 
                                                   id="technologies" name="technologies" value="{{ old('technologies') }}" 
                                                   placeholder="Laravel, Vue.js, Bootstrap, etc.">
                                            <div class="form-text">Separate technologies with commas</div>
                                            @error('technologies')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Project Media -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-image text-tertiary me-2"></i>
                                    Project Media
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="image" class="form-label">Project Image</label>
                                    <input type="file" class="form-control bg-white @error('image') is-invalid @enderror" 
                                           id="image" name="image">
                                    <div class="form-text">Recommended size: 1200x800 pixels. Max file size: 2MB.</div>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Project Details -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-align-left text-tertiary me-2"></i>
                                    Project Details
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control bg-white @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                                    <div class="form-text">Detailed description of the project.</div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Project Highlights -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-star text-tertiary me-2"></i>
                                    Project Highlights
                                </h6>
                                
                                <div class="highlights-container mb-3">
                                    @if(old('highlights'))
                                        @foreach(old('highlights') as $index => $highlight)
                                            <div class="highlight-item mb-2">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-white @error('highlights.'.$index) is-invalid @enderror" 
                                                           name="highlights[]" value="{{ $highlight }}" placeholder="Add a project highlight">
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
                                                       placeholder="Add a project highlight">
                                                <button type="button" class="btn btn-outline-danger remove-highlight" style="display: none;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="add-highlight">
                                    <i class="fas fa-plus"></i> Add Highlight
                                </button>
                            </div>
                        </div>

                        <!-- Project Settings -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-cog text-tertiary me-2"></i>
                                    Project Settings
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="order" class="form-label">Display Order</label>
                                            <input type="number" class="form-control bg-white @error('order') is-invalid @enderror" 
                                                   id="order" name="order" value="{{ old('order', 0) }}" min="0">
                                            <div class="form-text">Lower numbers appear first</div>
                                            @error('order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input bg-white" type="checkbox" id="featured" 
                                                   name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="featured">
                                                Feature this project
                                            </label>
                                            <div class="form-text">Featured projects appear in highlighted sections</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select bg-white @error('status') is-invalid @enderror" 
                                                    id="status" name="status" required>
                                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Create Project
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Tips -->
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-info-circle me-2 text-tertiary"></i>
                    Tips
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <h6 class="fw-bold">Creating Portfolio Items</h6>
                    <ul class="text-muted mb-0">
                        <li>Use high-quality images</li>
                        <li>Write clear descriptions</li>
                        <li>Add relevant highlights</li>
                        <li>Include project details</li>
                        <li>Set proper categories</li>
                    </ul>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Pro Tip:</strong> Featured projects get more visibility and appear in highlighted sections of your portfolio.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 0.5rem 1rem;
}

.form-control:focus, .form-select:focus {
    border-color: var(--bs-tertiary);
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-tertiary-rgb), 0.25);
}

.btn {
    border-radius: 8px;
    padding: 0.5rem 1.5rem;
}

.alert {
    border-radius: 8px;
}

.highlight-item .input-group {
    border-radius: 8px;
    overflow: hidden;
}

.highlight-item .form-control {
    border-radius: 8px 0 0 8px;
}

.highlight-item .btn {
    border-radius: 0 8px 8px 0;
}

.img-thumbnail {
    border: 1px solid #dee2e6;
    padding: 0.25rem;
}
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Project Highlights
        const highlightsContainer = document.querySelector('.highlights-container');
        const addHighlightBtn = document.getElementById('add-highlight');
        
        addHighlightBtn.addEventListener('click', function() {
            const highlightItem = document.createElement('div');
            highlightItem.className = 'highlight-item mb-2';
            highlightItem.innerHTML = `
                <div class="input-group">
                    <input type="text" class="form-control bg-white" name="highlights[]" placeholder="Add a project highlight">
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