@extends('layouts.admin')

@section('title', 'Services - Pxp3 Admin')

@section('header', 'Services')

@section('breadcrumb')
<li class="breadcrumb-item active">Services</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card rounded-5 border-0 shadow-lg">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-server me-2 text-tertiary"></i>
                        Manage Services
                    </h5>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-tertiary rounded-pill text-light">
                        <i class="fas fa-plus me-1"></i> Add Service
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="mb-4">
                    <form action="{{ route('admin.services.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control bg-white" placeholder="Search services..." value="{{ request('search') }}">
                                <button class="btn btn-tertiary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select bg-white" onChange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="featured" class="form-select bg-white" onChange="this.form.submit()">
                                <option value="">All Services</option>
                                <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured Only</option>
                                <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>

                @if($services->isEmpty())
                <div class="text-center py-5">
                    <div class="d-inline-block p-4 bg-light rounded-4 mb-3">
                        <i class="fas fa-server fa-3x text-secondary"></i>
                    </div>
                    <h4>No Services Found</h4>
                    <p class="text-muted mb-4">Start by adding a new service to your catalog</p>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add First Service
                    </a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 60px">ID</th>
                                <th>Title</th>
                                <th>Featured</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($service->image_path)
                                        <img src="{{ asset('storage/' . $service->image_path) }}" 
                                             alt="{{ $service->title }}" class="rounded me-2" 
                                             width="50" height="50" style="object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $service->title }}</h6>
                                            <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($service->featured)
                                    <span class="badge bg-warning rounded-pill bg-opacity-50">Featured</span>
                                    @else
                                    <span class="badge bg-light text-dark rounded-pill bg-opacity-50">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if($service->price)
                                    {{ number_format($service->price, 2) }}
                                    @if($service->price_period)
                                    <small class="text-muted">/ {{ $service->price_period }}</small>
                                    @endif
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($service->status === 'published')
                                    <span class="badge bg-success rounded-pill px-3 py-2 bg-opacity-50">Published</span>
                                    @else
                                    <span class="badge bg-secondary rounded-pill px-3 py-2 bg-opacity-50">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $service->order }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.services.show', $service) }}" class="btn btn-sm btn-outline-light">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-light">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $services->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 