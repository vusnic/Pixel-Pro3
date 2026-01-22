@extends('layouts.admin')

@section('title', 'Portfolio - Pxp3 Admin')

@section('header', 'Portfolio Projects')

@section('breadcrumb')
<li class="breadcrumb-item active">Portfolio</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card rounded-5 border-0 shadow-lg">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-briefcase me-2 text-tertiary"></i>
                        Manage Portfolio
                    </h5>
                    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-tertiary rounded-pill text-light">
                        <i class="fas fa-plus me-1"></i> Add Project
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
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="mb-4">
                    <form action="{{ route('admin.portfolio.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control bg-white" placeholder="Search projects..." value="{{ request('search') }}">
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
                                <option value="">All Projects</option>
                                <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured Only</option>
                                <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>
                
                @if($portfolios->isEmpty())
                <div class="text-center py-5">
                    <div class="d-inline-block p-4 bg-light rounded-4 mb-3">
                        <i class="fas fa-briefcase fa-3x text-secondary"></i>
                    </div>
                    <h4>No Projects Found</h4>
                    <p class="text-muted mb-4">Start by adding a new project to your portfolio</p>
                    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add First Project
                    </a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px">ID</th>
                                <th style="width: 100px">Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Date</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($portfolios as $portfolio)
                            <tr>
                                <td>{{ $portfolio->id }}</td>
                                <td>
                                    @if($portfolio->image_path)
                                        <img src="{{ asset('storage/' . $portfolio->image_path) }}" class="img-thumbnail" alt="{{ $portfolio->title }}" style="width: 80px; height: 60px; object-fit: cover;">
                                    @else
                                        <img src="https://placehold.co/80x60" class="img-thumbnail" alt="No Image">
                                    @endif
                                </td>
                                <td>{{ $portfolio->title }}</td>
                                <td>{{ ucfirst($portfolio->category) }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-opacity-50 bg-{{ $portfolio->status === 'published' ? 'success' : 'warning' }}">
                                        {{ ucfirst($portfolio->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-opacity-50 bg-{{ $portfolio->featured ? 'info' : 'secondary' }}">
                                        {{ $portfolio->featured ? 'Featured' : 'Regular' }}
                                    </span>
                                </td>
                                <td>{{ $portfolio->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.portfolio.show', $portfolio->id) }}" class="btn btn-sm btn-outline-light">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.portfolio.edit', $portfolio->id) }}" class="btn btn-sm btn-outline-light">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.portfolio.destroy', $portfolio->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this project?');">
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
                    {{ $portfolios->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 