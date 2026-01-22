@extends('layouts.admin')

@section('title', 'Contract Templates - Pxp3 Admin')

@section('header', 'Contract Templates')

@section('breadcrumb')
<li class="breadcrumb-item active">Contract Templates</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card rounded-5 border-0 shadow-lg">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-file-alt me-2 text-tertiary"></i>
                        Manage Templates
                    </h5>
                    <div>
                        <a href="{{ route('admin.contract-templates.verify') }}" class="btn btn-info btn-sm rounded-pill me-2">
                            <i class="fas fa-check me-1"></i> Verify Templates
                        </a>
                        <a href="{{ route('admin.contract-templates.create') }}" class="btn btn-tertiary rounded-pill text-light">
                            <i class="fas fa-plus me-1"></i> New Template
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($templates->isEmpty())
                <div class="text-center py-5">
                    <div class="d-inline-block p-4 bg-light rounded-4 mb-3">
                        <i class="fas fa-file-alt fa-3x text-secondary"></i>
                    </div>
                    <h4>No Templates Found</h4>
                    <p class="text-muted mb-4">No contract templates have been created yet</p>
                    <a href="{{ route('admin.contract-templates.create') }}" class="btn btn-tertiary rounded-pill">
                        <i class="fas fa-plus me-2"></i> Create Your First Template
                    </a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created on</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($templates as $template)
                                <tr>
                                    <td>{{ $template->name }}</td>
                                    <td>{{ $template->description ?? 'No description' }}</td>
                                    <td>
                                        @if ($template->is_active)
                                            <span class="badge bg-success rounded-pill px-3 py-2 bg-opacity-50">Active</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3 py-2 bg-opacity-50">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $template->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.contract-templates.show', $template) }}" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.contract-templates.edit', $template) }}" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.contract-templates.download', $template) }}" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <form action="{{ route('admin.contract-templates.destroy', $template) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-light" 
                                                    onclick="return confirm('Are you sure you want to delete this template?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No templates found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection