@extends('layouts.admin')

@section('title', 'Create New Contract - Pxp3 Admin')

@section('header', 'Create New Contract')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.contracts.index') }}">Contracts</a></li>
<li class="breadcrumb-item active">Create New</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-file-contract me-2 text-tertiary"></i>
                    Select Contract Template
                </h5>
            </div>
            <div class="card-body p-4">
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <form action="{{ route('admin.contracts.create-from-template') }}" method="POST">
                    @csrf
                    
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-list-alt text-tertiary me-2"></i>
                                    Choose a Template
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="template_id" class="form-label">Contract Template <span class="text-danger">*</span></label>
                                    <select class="form-select bg-white @error('template_id') is-invalid @enderror" 
                                            id="template_id" name="template_id" required>
                                        <option value="">Select a template...</option>
                                        @foreach($templates as $template)
                                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('template_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10 template-details d-none" id="templateDetails">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-info-circle text-tertiary me-2"></i>
                                    Template Details
                                </h6>
                                
                                <div class="mb-3">
                                    <p class="mb-2"><strong>Description:</strong> <span id="templateDescription"></span></p>
                                    <p class="mb-0"><strong>Fields:</strong> <span id="templatePlaceholders"></span></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.contracts.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-arrow-right me-2"></i> Continue
                                </button>
                            </div>
                        </div>
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
            <div class="card-body p-4">
                <div class="mb-3">
                    <h6 class="fw-bold">Creating Contracts</h6>
                    <ul class="text-muted mb-0">
                        <li>Select an appropriate template</li>
                        <li>Fill in all required information</li>
                        <li>Double-check client details</li>
                        <li>Verify payment terms before generating</li>
                    </ul>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Pro Tip:</strong> You can create your own templates from the Contract Templates section.
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Templates data
    const templates = @json($templates);
    
    // Show template details when selected
    $('#template_id').change(function() {
        const templateId = $(this).val();
        
        if (!templateId) {
            $('#templateDetails').addClass('d-none');
            return;
        }
        
        const template = templates.find(t => t.id == templateId);
        
        if (template) {
            $('#templateDescription').text(template.description || 'No description');
            
            let placeholders = '';
            if (template.placeholders && template.placeholders.length) {
                placeholders = template.placeholders.join(', ');
            } else {
                placeholders = 'No fields specified';
            }
            
            $('#templatePlaceholders').text(placeholders);
            $('#templateDetails').removeClass('d-none');
        }
    });
</script>
@endpush

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
</style>
@endsection