@extends('layouts.admin')

@section('title', 'New Contract Template - Pxp3 Admin')

@section('header', 'New Contract Template')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.contract-templates.index') }}">Contract Templates</a></li>
<li class="breadcrumb-item active">Create New</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-file-contract me-2 text-tertiary"></i>
                    New Contract Template
                </h5>
            </div>
            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <form id="templateForm" action="{{ route('admin.contract-templates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Template Basic Information -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-info-circle text-tertiary me-2"></i>
                                    Basic Information
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Template Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white @error('name') is-invalid @enderror" 
                                                id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control bg-white @error('description') is-invalid @enderror" 
                                                id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Template File Upload -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-file-upload text-tertiary me-2"></i>
                                    Document Upload
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="template_file" class="form-label">Template File (DOCX) <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control bg-white @error('template_file') is-invalid @enderror" 
                                                id="template_file" name="template_file" accept=".docx" required>
                                            @error('template_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted mt-2">
                                                The file must be in DOCX format with dynamic fields in curly braces. Example: {ClientName}, {StartDate}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Template Placeholders -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-tags text-tertiary me-2"></i>
                                    Dynamic Fields
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="placeholders" class="form-label">Placeholders (comma-separated) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white @error('placeholders') is-invalid @enderror" 
                                                id="placeholders" name="placeholders" 
                                                value="{{ old('placeholders', 'ClientName,ClientAddress,ServiceType,ProjectDescription,StartDate,DeliveryDate,TotalValue,PaymentMethod,PaymentTerms,Warranty,SalesRepName') }}">
                                            @error('placeholders')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted mt-2">
                                                List of comma-separated placeholders that will be replaced in the document.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="col-12">
                            <div id="processingMessage" style="display:none;" class="alert alert-info mb-3">
                                <i class="fas fa-spinner fa-spin me-2"></i> Submitting form and uploading file. This may take a moment...
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.contract-templates.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </a>
                                <button type="submit" id="submitBtn" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Save Template
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
                    <i class="fas fa-lightbulb me-2 text-tertiary"></i>
                    Guidelines
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <h6 class="fw-bold">Creating Contract Templates</h6>
                    <p class="text-muted mb-3">Contract templates are Microsoft Word (DOCX) files with placeholders that will be replaced with actual data when generating contracts.</p>
                    
                    <h6 class="fw-bold">How to Format Placeholders</h6>
                    <ul class="text-muted mb-3">
                        <li>Use curly braces: {PlaceholderName}</li>
                        <li>No spaces in placeholder names</li>
                        <li>Case sensitive (use consistent capitalization)</li>
                    </ul>
                    
                    <h6 class="fw-bold">Common Placeholders</h6>
                    <ul class="text-muted">
                        <li>ClientName - Full name of the client</li>
                        <li>ClientAddress - Complete address</li>
                        <li>StartDate - Project start date</li>
                        <li>TotalValue - Full project cost</li>
                        <li>PaymentTerms - Payment conditions</li>
                    </ul>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Pro Tip:</strong> Test your template with a sample contract generation after uploading.
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update the name of the selected file
        document.getElementById('template_file').addEventListener('change', function() {
            var fileName = this.files[0].name;
            this.nextElementSibling = fileName;
        });
        
        // Show message during form submission
        document.getElementById('templateForm').addEventListener('submit', function() {
            document.getElementById('processingMessage').style.display = 'block';
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
        });
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