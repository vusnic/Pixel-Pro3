@extends('layouts.admin')

@section('title', 'Contract Template Details')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contract Template Details</h1>
        <div>
            <a href="{{ route('admin.contract-templates.download', $contractTemplate) }}" class="btn btn-success btn-sm shadow-sm mr-2">
                <i class="fas fa-download fa-sm text-white-50"></i> Download
            </a>
            <a href="{{ route('admin.contract-templates.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Template Information</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Actions:</div>
                            <a class="dropdown-item" href="{{ route('admin.contract-templates.edit', $contractTemplate) }}">
                                <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i> Edit
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.contract-templates.download', $contractTemplate) }}">
                                <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i> Download
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('admin.contract-templates.destroy', $contractTemplate) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this template?')">
                                    <i class="fas fa-trash fa-sm fa-fw mr-2 text-danger"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="font-weight-bold text-primary mb-1">Template Name</h5>
                        <p>{{ $contractTemplate->name }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="font-weight-bold text-primary mb-1">Description</h5>
                        <p>{{ $contractTemplate->description ?? 'No description provided' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="font-weight-bold text-primary mb-1">Status</h5>
                        <p>
                            @if($contractTemplate->is_active)
                                <span class="badge badge-success p-2">Active</span>
                            @else
                                <span class="badge badge-danger p-2">Inactive</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="font-weight-bold text-primary mb-1">File</h5>
                        <p>{{ basename($contractTemplate->file_path) }}</p>
                        <a href="{{ route('admin.contract-templates.download', $contractTemplate) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Placeholders (Fields)</h6>
                </div>
                <div class="card-body">
                    @if(is_array($contractTemplate->placeholders) && count($contractTemplate->placeholders) > 0)
                        <div class="list-group">
                            @foreach($contractTemplate->placeholders as $placeholder)
                                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span><code>{{{ $placeholder }}}</code></span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No placeholders defined for this template.</p>
                    @endif
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Additional Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="font-weight-bold text-warning mb-1">Created on</h5>
                        <p>{{ $contractTemplate->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h5 class="font-weight-bold text-warning mb-1">Updated on</h5>
                        <p>{{ $contractTemplate->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h5 class="font-weight-bold text-warning mb-1">Created by</h5>
                        <p>{{ $contractTemplate->creator->name ?? 'Unknown user' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.contract-templates.edit', $contractTemplate) }}" class="btn btn-primary mr-2">
                        <i class="fas fa-edit"></i> Edit Template
                    </a>
                    
                    <a href="{{ route('admin.contracts.create') }}" class="btn btn-success mr-2">
                        <i class="fas fa-file-signature"></i> Create Contract
                    </a>
                    
                    <form action="{{ route('admin.contract-templates.destroy', $contractTemplate) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this template?')">
                            <i class="fas fa-trash"></i> Delete Template
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 