@extends('layouts.admin')

@section('title', 'Portfolio Categories - Pxp3 Admin')

@section('header', 'Portfolio Categories')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index') }}">Portfolio</a></li>
<li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Portfolio Categories</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i> 
                    Categories are automatically created when you add them to projects. This page shows all categories currently in use.
                </div>
                
                <div class="mb-4">
                    <h5 class="border-bottom pb-2">Available Categories</h5>
                    
                    @if($categories->isEmpty())
                        <div class="alert alert-light">
                            No categories found. Add some projects with categories to see them listed here.
                        </div>
                    @else
                        <div class="row">
                            @foreach($categories as $category)
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-dark h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="category-icon me-3">
                                                <i class="fas fa-folder text-primary fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-0">{{ ucfirst($category) }}</h5>
                                                <small class="text-muted">
                                                    @php
                                                        $count = App\Models\Portfolio::where('category', $category)->count();
                                                    @endphp
                                                    {{ $count }} {{ Str::plural('project', $count) }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-dark border-top-0">
                                            <a href="{{ route('admin.portfolio.index', ['category' => $category]) }}" class="btn btn-outline-light btn-sm">
                                                <i class="fas fa-eye me-1"></i> View Projects
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Create Project with New Category
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Category Management Tips</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="fas fa-lightbulb text-warning me-2"></i> Organization</h5>
                        <p>Categorize your projects in a way that makes sense to your visitors. Good categories make it easier for visitors to find what they're looking for.</p>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="fas fa-tags text-warning me-2"></i> Category Names</h5>
                        <p>Use clear and concise names for your categories. Avoid technical jargon and use terms your audience will understand.</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h5><i class="fas fa-balance-scale text-warning me-2"></i> Balance</h5>
                        <p>Try to maintain a balance in the number of projects in each category. Avoid having some categories with many projects and others with very few.</p>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="fas fa-chart-line text-warning me-2"></i> Trends</h5>
                        <p>Keep an eye on which categories are most viewed. This can provide insights into what your audience is interested in.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 