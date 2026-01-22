@extends('layouts.admin')

@section('title', 'Contract Management - Pxp3 Admin')

@section('header', 'Contracts')

@section('breadcrumb')
<li class="breadcrumb-item active">Contracts</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card rounded-5 border-0 shadow-lg">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-file-contract me-2 text-tertiary"></i>
                        Manage Contracts
                    </h5>
                    <a href="{{ route('admin.contracts.create') }}" class="btn btn-tertiary rounded-pill text-light">
                        <i class="fas fa-plus me-1"></i> New Contract
                    </a>
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

                @if($contracts->isEmpty())
                <div class="text-center py-5">
                    <div class="d-inline-block p-4 bg-light rounded-4 mb-3">
                        <i class="fas fa-file-contract fa-3x text-secondary"></i>
                    </div>
                    <h4>No Contracts Found</h4>
                    <p class="text-muted mb-4">No contracts have been generated yet</p>
                    <a href="{{ route('admin.contracts.create') }}" class="btn btn-tertiary rounded-pill">
                        <i class="fas fa-plus me-2"></i> Create Your First Contract
                    </a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Service</th>
                                <th>Value</th>
                                <th>Start Date</th>
                                <th>Delivery Date</th>
                                <th>Type</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contracts as $contract)
                                <tr>
                                    <td>{{ $contract->client_name }}</td>
                                    <td>{{ $contract->service_type }}</td>
                                    <td>R$ {{ number_format($contract->total_value, 2, ',', '.') }}</td>
                                    <td>{{ $contract->start_date->format('d/m/Y') }}</td>
                                    <td>{{ $contract->delivery_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge {{ $contract->file_type == 'pdf' ? 'bg-danger' : 'bg-primary' }} rounded-pill px-3 py-2 bg-opacity-50">
                                            {{ strtoupper($contract->file_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.contracts.show', $contract) }}" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.contracts.download', $contract) }}" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <form action="{{ route('admin.contracts.destroy', $contract) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-light" 
                                                    onclick="return confirm('Are you sure you want to delete this contract?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No contracts found.</td>
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