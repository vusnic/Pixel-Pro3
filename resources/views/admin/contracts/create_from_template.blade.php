@extends('layouts.admin')

@section('title', 'Fill Contract Data - Pxp3 Admin')

@section('header', 'Fill Contract Data')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.contracts.index') }}">Contracts</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.contracts.create') }}">Create New</a></li>
<li class="breadcrumb-item active">Fill Data</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-file-contract me-2 text-tertiary"></i>
                    Contract Form: {{ $template->name }}
                </h5>
            </div>
            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <form action="{{ route('admin.contracts.generate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="template_id" value="{{ $template->id }}">
                    
                    <div class="row g-4">
                        <!-- Contract Information -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-file-contract text-tertiary me-2"></i>
                                    Contract Information
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Contract Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', 'Contract ' . date('d/m/Y')) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="format" class="form-label">Document Format <span class="text-danger">*</span></label>
                                            <select class="form-select bg-white @error('format') is-invalid @enderror" 
                                                    id="format" name="format" required>
                                                <option value="docx" {{ old('format') == 'docx' ? 'selected' : '' }}>DOCX (Word)</option>
                                                <option value="pdf" {{ old('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                            </select>
                                            @error('format')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Client Information -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-user-tie text-tertiary me-2"></i>
                                    Client Information
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ClientName" class="form-label">Client Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white @error('ClientName') is-invalid @enderror" 
                                                   id="ClientName" name="ClientName" value="{{ old('ClientName') }}" required>
                                            @error('ClientName')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ClientAddress" class="form-label">Client Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white @error('ClientAddress') is-invalid @enderror" 
                                                   id="ClientAddress" name="ClientAddress" value="{{ old('ClientAddress') }}" required>
                                            @error('ClientAddress')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Project Details -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-project-diagram text-tertiary me-2"></i>
                                    Project Details
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ServiceType" class="form-label">Service Type <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white @error('ServiceType') is-invalid @enderror" 
                                                   id="ServiceType" name="ServiceType" value="{{ old('ServiceType') }}" required>
                                            @error('ServiceType')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="ProjectDescription" class="form-label">Project Description <span class="text-danger">*</span></label>
                                            <textarea class="form-control bg-white @error('ProjectDescription') is-invalid @enderror" 
                                                      id="ProjectDescription" name="ProjectDescription" rows="3" required>{{ old('ProjectDescription') }}</textarea>
                                            @error('ProjectDescription')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dates and Values -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-calendar-alt text-tertiary me-2"></i>
                                    Dates and Values
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="StartDate" class="form-label">Start Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control bg-white @error('StartDate') is-invalid @enderror" 
                                                   id="StartDate" name="StartDate" value="{{ old('StartDate', date('Y-m-d')) }}" required>
                                            @error('StartDate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="DeliveryDate" class="form-label">Delivery Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control bg-white @error('DeliveryDate') is-invalid @enderror" 
                                                   id="DeliveryDate" name="DeliveryDate" value="{{ old('DeliveryDate', date('Y-m-d', strtotime('+30 days'))) }}" required>
                                            @error('DeliveryDate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="TotalValue" class="form-label">Total Value <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white">R$</span>
                                                <input type="number" step="0.01" min="0" class="form-control bg-white @error('TotalValue') is-invalid @enderror" 
                                                       id="TotalValue" name="TotalValue" value="{{ old('TotalValue') }}" required>
                                                @error('TotalValue')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment and Warranty -->
                        <div class="col-12">
                            <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-money-check-alt text-tertiary me-2"></i>
                                    Payment and Warranty
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="PaymentMethod" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white @error('PaymentMethod') is-invalid @enderror" 
                                                   id="PaymentMethod" name="PaymentMethod" value="{{ old('PaymentMethod') }}" required>
                                            @error('PaymentMethod')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="Warranty" class="form-label">Warranty <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white @error('Warranty') is-invalid @enderror" 
                                                   id="Warranty" name="Warranty" value="{{ old('Warranty', '90 days') }}" required>
                                            @error('Warranty')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="PaymentTerms" class="form-label">Payment Terms <span class="text-danger">*</span></label>
                                            <textarea class="form-control bg-white @error('PaymentTerms') is-invalid @enderror" 
                                                      id="PaymentTerms" name="PaymentTerms" rows="2" required>{{ old('PaymentTerms') }}</textarea>
                                            @error('PaymentTerms')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Fields -->
                        @if($template->placeholders)
                            @foreach($template->placeholders as $placeholder)
                                @if(!in_array($placeholder, ['ClientName', 'ClientAddress', 'ServiceType', 'ProjectDescription', 'StartDate', 'DeliveryDate', 'TotalValue', 'PaymentMethod', 'PaymentTerms', 'Warranty']))
                                <div class="col-12">
                                    <div class="p-4 rounded-4 bg-light bg-opacity-10">
                                        <h6 class="fw-bold mb-3">
                                            <i class="fas fa-plus-circle text-tertiary me-2"></i>
                                            {{ str_replace('_', ' ', $placeholder) }}
                                        </h6>
                                        
                                        <div class="mb-3">
                                            <label for="{{ $placeholder }}" class="form-label">{{ str_replace('_', ' ', $placeholder) }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white @error($placeholder) is-invalid @enderror" 
                                                   id="{{ $placeholder }}" name="{{ $placeholder }}" value="{{ old($placeholder) }}" required>
                                            @error($placeholder)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endif
                        
                        <!-- Actions -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.contracts.create') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-file-alt me-2"></i> Generate Contract
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
                    Template Information
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <h6 class="fw-bold">{{ $template->name }}</h6>
                    <p class="text-muted mb-3">{{ $template->description ?? 'No description available' }}</p>
                    
                    <h6 class="fw-bold">Required Fields</h6>
                    <ul class="text-muted">
                        @if($template->placeholders && count($template->placeholders) > 0)
                            @foreach($template->placeholders as $placeholder)
                                <li>{{ str_replace('_', ' ', $placeholder) }}</li>
                            @endforeach
                        @else
                            <li>No specific fields required</li>
                        @endif
                    </ul>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Pro Tip:</strong> Double-check all information before generating the contract to avoid errors.
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

.input-group .input-group-text {
    border-radius: 8px 0 0 8px;
    border: 1px solid #dee2e6;
}

.input-group .form-control {
    border-radius: 0 8px 8px 0;
}
</style>
@endsection