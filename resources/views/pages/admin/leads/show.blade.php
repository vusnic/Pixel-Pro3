@extends('layouts.admin')

@section('title', 'Lead Details - Pxp3 Admin')

@section('header', 'Lead Details')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.leads.index') }}">Leads</a></li>
<li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-user-tag me-2 text-tertiary"></i>
                        Lead Information
                    </h5>
                    <div class="d-flex align-items-center">
                        @if ($lead->status === 'new')
                            <span class="badge bg-success rounded-pill px-3 py-2">New</span>
                        @elseif ($lead->status === 'contacted')
                            <span class="badge bg-primary rounded-pill px-3 py-2">Contacted</span>
                        @elseif ($lead->status === 'qualified')
                            <span class="badge bg-info rounded-pill px-3 py-2">Qualified</span>
                        @elseif ($lead->status === 'converted')
                            <span class="badge bg-warning rounded-pill px-3 py-2">Converted</span>
                        @else
                            <span class="badge bg-secondary rounded-pill px-3 py-2">Closed</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($lead->name) }}&background=random&color=fff&size=128" 
                                 class="rounded-circle me-3" alt="{{ $lead->name }}" width="64" height="64">
                            <div>
                                <h4 class="mb-1">{{ $lead->name }}</h4>
                                <div class="text-muted">
                                    <i class="fas fa-clock me-1"></i> Created {{ $lead->created_at->diffForHumans() }}
                                    <span class="mx-2">•</span>
                                    <span class="badge bg-{{ $lead->source === 'homepage' ? 'primary' : 'info' }} rounded-pill">
                                        <i class="fas {{ $lead->source === 'homepage' ? 'fa-home' : 'fa-globe' }} me-1"></i>
                                        {{ ucfirst($lead->source) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 bg-light bg-opacity-10">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-address-card text-tertiary me-2"></i>
                                Contact Details
                            </h6>
                            
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Email Address</label>
                                <div class="d-flex align-items-center">
                                    <a href="mailto:{{ $lead->email }}" class="text-decoration-none d-flex align-items-center">
                                        <i class="fas fa-envelope text-tertiary me-2"></i>
                                        {{ $lead->email }}
                                    </a>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Phone Number</label>
                                <div class="d-flex align-items-center">
                                    <a href="tel:{{ $lead->full_phone }}" class="text-decoration-none d-flex align-items-center">
                                        <i class="fas fa-phone text-tertiary me-2"></i>
                                        {{ $lead->full_phone }}
                                    </a>
                                </div>
                            </div>
                            
                            <div>
                                <label class="text-muted small mb-1">Website</label>
                                <div class="d-flex align-items-center">
                                    @if ($lead->website)
                                        <a href="{{ $lead->website }}" target="_blank" class="text-decoration-none d-flex align-items-center">
                                            <i class="fas fa-globe text-tertiary me-2"></i>
                                            {{ $lead->website }}
                                        </a>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-globe me-2"></i>
                                            Not provided
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lead Details -->
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 bg-light bg-opacity-10">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-info-circle text-tertiary me-2"></i>
                                Lead Details
                            </h6>
                            
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Created Date</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar text-tertiary me-2"></i>
                                    {{ $lead->created_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Source</label>
                                <div>
                                    <span class="badge bg-{{ $lead->source === 'homepage' ? 'primary' : 'info' }} rounded-pill px-3">
                                        <i class="fas {{ $lead->source === 'homepage' ? 'fa-home' : 'fa-globe' }} me-1"></i>
                                        {{ ucfirst($lead->source) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="text-muted small mb-1">Status History</label>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success rounded-pill me-2">New</span>
                                    <i class="fas fa-arrow-right text-muted mx-2"></i>
                                    <span class="badge bg-{{ $lead->status === 'new' ? 'success' : 'primary' }} rounded-pill">
                                        {{ ucfirst($lead->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="col-12">
                        <div class="p-4 rounded-4 bg-light bg-opacity-10">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-comment text-tertiary me-2"></i>
                                Message
                            </h6>
                            
                            @if ($lead->message)
                                <p class="mb-0">{{ $lead->message }}</p>
                            @else
                                <p class="text-muted mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No message provided
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Status Update -->
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-tasks me-2 text-tertiary"></i>
                    Update Status
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.leads.update.status', $lead) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <select class="form-select bg-light bg-opacity-10 border-0" id="status" name="status" required>
                            <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>New Lead</option>
                            <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="qualified" {{ $lead->status === 'qualified' ? 'selected' : '' }}>Qualified</option>
                            <option value="converted" {{ $lead->status === 'converted' ? 'selected' : '' }}>Converted</option>
                            <option value="closed" {{ $lead->status === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-tertiary">
                            <i class="fas fa-save me-2"></i> Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-bolt me-2 text-tertiary"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="mailto:{{ $lead->email }}" class="list-group-item list-group-item-action d-flex align-items-center p-3">
                        <i class="fas fa-envelope text-tertiary me-3"></i>
                        Send Email
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                    <a href="tel:{{ $lead->full_phone }}" class="list-group-item list-group-item-action d-flex align-items-center p-3">
                        <i class="fas fa-phone text-tertiary me-3"></i>
                        Call Lead
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                    @if ($lead->website)
                        <a href="{{ $lead->website }}" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center p-3">
                            <i class="fas fa-globe text-tertiary me-3"></i>
                            Visit Website
                            <i class="fas fa-chevron-right ms-auto"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card rounded-5 border-0 shadow-lg">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-cog me-2 text-tertiary"></i>
                    Actions
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary flex-grow-1">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                    <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="flex-grow-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100" 
                                onclick="return confirm('Are you sure you want to delete this lead?')">
                            <i class="fas fa-trash me-2"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.list-group-item-action {
    transition: all 0.2s ease;
}

.list-group-item-action:hover {
    background-color: var(--bs-tertiary-bg);
    padding-left: 1.5rem !important;
}

.form-select {
    height: 45px;
}

.badge {
    font-weight: 500;
}
</style>
@endsection 