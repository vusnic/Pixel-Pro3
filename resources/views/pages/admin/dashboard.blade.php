@extends('layouts.admin')

@section('title', 'Dashboard - Pxp3 Admin')

@section('header', 'Dashboard')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
        <i class="fas fa-check-circle me-3 fa-lg"></i>
        <span>{{ session('success') }}</span>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(isset($dataSource) && ($dataSource['visitors'] !== 'real' || $dataSource['metrics'] !== 'real'))
<div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
        <i class="fas fa-info-circle me-3 fa-lg"></i>
        <div>
            <h5 class="alert-heading mb-1">Analytics Data Information</h5>
            <p class="mb-0">
                @if($dataSource['visitors'] === 'simulado' && $dataSource['metrics'] === 'simulado')
                    All analytics data currently displayed is simulated because the system couldn't access real Google Analytics data.
                @elseif($dataSource['visitors'] === 'simulado')
                    Visitor data in the chart is simulated because the system couldn't access this data from Google Analytics.
                @elseif($dataSource['metrics'] === 'simulado' || $dataSource['metrics'] === 'parcialmente_simulado')
                    Some analytics metrics are simulated because the system couldn't access all real data from Google Analytics.
                @endif
                Please check the Google Analytics API configuration or look for the indicators <i class="fas fa-info-circle text-success"></i> (real data), <i class="fas fa-info-circle text-warning"></i> (partially simulated) and <i class="fas fa-info-circle text-danger"></i> (simulated data) next to each metric.
            </p>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(isset($dataSource) && $dataSource['visitors'] === 'real' && $dataSource['metrics'] === 'real')
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
        <i class="fas fa-chart-line me-3 fa-lg"></i>
        <div>
            <h5 class="alert-heading mb-1">Real Analytics Data</h5>
            <p class="mb-0">
                You are viewing real Google Analytics data. The data is updated every 24-48 hours by Google Analytics, and cached for 1 hour in the system. Last cache update: {{ now()->format('H:i') }}.
            </p>
        </div>
    </div>
    <div class="mt-2">
        <a href="{{ route('admin.dashboard') }}?clear_cache=1" class="btn btn-sm btn-outline-success">
            <i class="fas fa-sync-alt me-1"></i> Refresh Analytics Data
        </a>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<!-- Stats Overview -->
<div class="row" data-aos="fade-up">
    <div class="col-lg-3 col-12">
        <div class="card rounded-5 overflow-hidden border-0 shadow-lg" data-aos="zoom-in" data-aos-delay="100">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-4 bg-info d-flex align-items-center justify-content-center py-4">
                        <i class="fas fa-users fa-3x text-white opacity-75"></i>
                    </div>
                    <div class="col-8 p-4">
                        <div class="d-flex flex-column">
                            <h3 class="fw-bold mb-1">{{ number_format($stats['users']) }}</h3>
                            <p class="text-secondary mb-0">Total Users</p>
                            <a href="{{ route('admin.users.index') }}" class="mt-2 text-info text-decoration-none small">
                                <span>View details</span>
                                <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-12">
        <div class="card rounded-5 overflow-hidden border-0 shadow-lg" data-aos="zoom-in" data-aos-delay="200">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-4 bg-success d-flex align-items-center justify-content-center py-4">
                        <i class="fas fa-user-tag fa-3x text-white opacity-75"></i>
                    </div>
                    <div class="col-8 p-4">
                        <div class="d-flex flex-column">
                            <h3 class="fw-bold mb-1">{{ number_format($stats['leads']) }}</h3>
                            <p class="text-secondary mb-0">Total Leads</p>
                            <a href="{{ route('admin.leads.index') }}" class="mt-2 text-success text-decoration-none small">
                                <span>View details</span>
                                <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-12">
        <div class="card rounded-5 overflow-hidden border-0 shadow-lg" data-aos="zoom-in" data-aos-delay="300">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-4 bg-warning d-flex align-items-center justify-content-center py-4">
                        <i class="fas fa-project-diagram fa-3x text-white opacity-75"></i>
                    </div>
                    <div class="col-8 p-4">
                        <div class="d-flex flex-column">
                            <h3 class="fw-bold mb-1">{{ number_format($stats['projects']) }}</h3>
                            <p class="text-secondary mb-0">Projects</p>
                            <a href="{{ route('admin.portfolio.index') }}" class="mt-2 text-warning text-decoration-none small">
                                <span>View details</span>
                                <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-12">
        <div class="card rounded-5 overflow-hidden border-0 shadow-lg" data-aos="zoom-in" data-aos-delay="400">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-4 bg-tertiary d-flex align-items-center justify-content-center py-4">
                        <i class="fas fa-chart-line fa-3x text-white opacity-75"></i>
                    </div>
                    <div class="col-8 p-4">
                        <div class="d-flex flex-column">
                            <h3 class="fw-bold mb-1">
                                {{ number_format($stats['views']) }}
                                @if(isset($dataSource))
                                    <i class="fas fa-info-circle text-{{ $dataSource['metrics'] === 'real' ? 'success' : ($dataSource['metrics'] === 'parcialmente_simulado' ? 'warning' : 'danger') }}" 
                                       data-bs-toggle="tooltip" title="{{ $dataSource['metrics'] === 'real' ? 'Real data' : ($dataSource['metrics'] === 'parcialmente_simulado' ? 'Partially simulated' : 'Simulated data') }}"></i>
                                @endif
                            </h3>
                            <p class="text-secondary mb-0">Page Views</p>
                            <span class="mt-2 text-tertiary text-decoration-none small">
                                <span>Scroll down</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Main Chart -->
    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
        <div class="card rounded-5 border-0 shadow-lg overflow-hidden">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-line me-2 text-tertiary"></i>
                        Visitor Analytics
                        @if(isset($dataSource))
                            <span class="badge {{ $dataSource['visitors'] === 'real' ? 'bg-success' : 'bg-danger' }} ms-2 rounded-pill">
                                {{ $dataSource['visitors'] === 'real' ? 'Real data' : 'Simulated data' }}
                            </span>
                        @endif
                    </h5>
                    <div class="btn-group period-selector-group">
                        <button type="button" class="btn btn-sm btn-tertiary rounded-start-pill px-3 period-selector" data-period="7">Weekly</button>
                        <button type="button" class="btn btn-sm btn-outline-tertiary px-3 period-selector" data-period="30">Monthly</button>
                        <button type="button" class="btn btn-sm btn-outline-tertiary rounded-end-pill px-3 period-selector" data-period="365">Yearly</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="visitorChart"></canvas>
                </div>
                <div class="row mt-4 text-center">
                    <div class="col-md-3 col-6 mb-3">
                        <div class="p-3 rounded-4 bg-tertiary bg-opacity-10">
                            <h6 class="text-secondary small mb-2">
                                TOTAL VIEWS
                                @if(isset($dataSource))
                                    <i class="fas fa-info-circle text-{{ $dataSource['metrics'] === 'real' ? 'success' : ($dataSource['metrics'] === 'parcialmente_simulado' ? 'warning' : 'danger') }}" 
                                       data-bs-toggle="tooltip" title="{{ $dataSource['metrics'] === 'real' ? 'Real data' : ($dataSource['metrics'] === 'parcialmente_simulado' ? 'Partially simulated' : 'Simulated data') }}"></i>
                                @endif
                            </h6>
                            <h4 class="mb-1 fw-bold">{{ number_format($stats['views']) }}</h4>
                            <span class="badge bg-{{ $analyticsMetrics['pageViewsGrowth'] > 0 ? 'success' : 'danger' }} rounded-pill px-2">
                                {{ $analyticsMetrics['pageViewsGrowth'] > 0 ? '+' : '' }}{{ number_format($analyticsMetrics['pageViewsGrowth'], 1) }}%
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="p-3 rounded-4 bg-tertiary bg-opacity-10">
                            <h6 class="text-secondary small mb-2">
                                UNIQ. VISITORS
                                @if(isset($dataSource))
                                    <i class="fas fa-info-circle text-{{ $dataSource['metrics'] === 'real' ? 'success' : ($dataSource['metrics'] === 'parcialmente_simulado' ? 'warning' : 'danger') }}" 
                                       data-bs-toggle="tooltip" title="{{ $dataSource['metrics'] === 'real' ? 'Real data' : ($dataSource['metrics'] === 'parcialmente_simulado' ? 'Partially simulated' : 'Simulated data') }}"></i>
                                @endif
                            </h6>
                            <h4 class="mb-1 fw-bold">{{ number_format($analyticsMetrics['totalVisitors']) }}</h4>
                            <span class="badge bg-{{ $analyticsMetrics['visitorsGrowth'] > 0 ? 'success' : 'danger' }} rounded-pill px-2">
                                {{ $analyticsMetrics['visitorsGrowth'] > 0 ? '+' : '' }}{{ number_format($analyticsMetrics['visitorsGrowth'], 1) }}%
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="p-3 rounded-4 bg-tertiary bg-opacity-10">
                            <h6 class="text-secondary small mb-2">
                                BOUNCE RATE
                                @if(isset($dataSource))
                                    <i class="fas fa-info-circle text-{{ $dataSource['metrics'] === 'real' ? 'success' : ($dataSource['metrics'] === 'parcialmente_simulado' ? 'warning' : 'danger') }}" 
                                       data-bs-toggle="tooltip" title="{{ $dataSource['metrics'] === 'real' ? 'Real data' : ($dataSource['metrics'] === 'parcialmente_simulado' ? 'Partially simulated' : 'Simulated data') }}"></i>
                                @endif
                            </h6>
                            <h4 class="mb-1 fw-bold">{{ number_format($analyticsMetrics['bounceRate'], 1) }}%</h4>
                            <span class="badge bg-{{ $analyticsMetrics['bounceRateGrowth'] < 0 ? 'success' : 'danger' }} rounded-pill px-2">
                                {{ $analyticsMetrics['bounceRateGrowth'] > 0 ? '+' : '' }}{{ number_format($analyticsMetrics['bounceRateGrowth'], 1) }}%
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="p-3 rounded-4 bg-tertiary bg-opacity-10">
                            <h6 class="text-secondary small mb-2">
                                AVG. DURATION
                                @if(isset($dataSource))
                                    <i class="fas fa-info-circle text-{{ $dataSource['metrics'] === 'real' ? 'success' : ($dataSource['metrics'] === 'parcialmente_simulado' ? 'warning' : 'danger') }}" 
                                       data-bs-toggle="tooltip" title="{{ $dataSource['metrics'] === 'real' ? 'Real data' : ($dataSource['metrics'] === 'parcialmente_simulado' ? 'Partially simulated' : 'Simulated data') }}"></i>
                                @endif
                            </h6>
                            <h4 class="mb-1 fw-bold">{{ floor($analyticsMetrics['avgSessionDuration'] / 60) }}m {{ $analyticsMetrics['avgSessionDuration'] % 60 }}s</h4>
                            <span class="badge bg-{{ $analyticsMetrics['durationGrowth'] > 0 ? 'success' : 'danger' }} rounded-pill px-2">
                                {{ $analyticsMetrics['durationGrowth'] > 0 ? '+' : '' }}{{ number_format($analyticsMetrics['durationGrowth'], 1) }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Lead Stats Donut -->
    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card rounded-5 border-0 shadow-lg h-100">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-chart-pie me-2 text-tertiary"></i>
                    Lead Status
                </h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="chart-responsive mb-4">
                    <canvas id="leadStatusChart" height="220"></canvas>
                </div>
                <div class="mt-auto">
                    <div class="row gx-2 gy-2 text-center">
                        <div class="col">
                            <div class="p-3 rounded-4 bg-success bg-opacity-10">
                                <h5 class="mb-0 fw-bold">{{ $leadsByStatus['new'] ?? 0 }}</h5>
                                <small class="text-success">New</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 rounded-4 bg-primary bg-opacity-10">
                                <h5 class="mb-0 fw-bold">{{ $leadsByStatus['contacted'] ?? 0 }}</h5>
                                <small class="text-primary">Contacted</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 rounded-4 bg-info bg-opacity-10">
                                <h5 class="mb-0 fw-bold">{{ $leadsByStatus['qualified'] ?? 0 }}</h5>
                                <small class="text-info">Qualified</small>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-2 gy-2 mt-2 text-center">
                        <div class="col">
                            <div class="p-3 rounded-4 bg-warning bg-opacity-10">
                                <h5 class="mb-0 fw-bold">{{ $leadsByStatus['converted'] ?? 0 }}</h5>
                                <small class="text-warning">Converted</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 rounded-4 bg-secondary bg-opacity-10">
                                <h5 class="mb-0 fw-bold">{{ $leadsByStatus['closed'] ?? 0 }}</h5>
                                <small class="text-secondary">Closed</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 rounded-4 bg-tertiary bg-opacity-10">
                                <h5 class="mb-0 fw-bold">{{ array_sum($leadsByStatus) }}</h5>
                                <small class="text-tertiary">Total</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest Leads -->
<div class="row mt-4">
    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
        <div class="card rounded-5 border-0 shadow-lg">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-user-tag me-2 text-tertiary"></i>
                        Recent Leads
                    </h5>
                    <a href="{{ route('admin.leads.index') }}" class="btn btn-sm btn-tertiary rounded-pill text-light">
                        View All
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @forelse($latestLeads as $lead)
                            <tr>
                                <td width="50">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($lead->name) }}&background=random" 
                                         class="rounded-circle" alt="{{ $lead->name }}" width="40" height="40">
                                </td>
                                <td>
                                    <p class="mb-0 fw-bold">{{ $lead->name }}</p>
                                    <p class="mb-0 small text-secondary">{{ $lead->email }}</p>
                                </td>
                                <td>
                                    <p class="mb-0">{{ $lead->country_code }} {{ $lead->phone }}</p>
                                    <p class="mb-0 small text-secondary"><i class="fas fa-tag me-1"></i>{{ ucfirst($lead->source) }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 small"><i class="far fa-clock me-1"></i>{{ $lead->created_at->diffForHumans() }}</p>
                                </td>
                                <td width="120">
                                    @if($lead->status === 'new')
                                        <span class="badge bg-success rounded-pill px-3 py-2">New</span>
                                    @elseif($lead->status === 'contacted')
                                        <span class="badge bg-primary rounded-pill px-3 py-2">Contacted</span>
                                    @elseif($lead->status === 'qualified')
                                        <span class="badge bg-info rounded-pill px-3 py-2">Qualified</span>
                                    @elseif($lead->status === 'converted')
                                        <span class="badge bg-warning rounded-pill px-3 py-2">Converted</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">Closed</span>
                                    @endif
                                </td>
                                <td width="50" class="text-end">
                                    <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-sm btn-tertiary rounded-circle">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-inbox fa-3x text-secondary mb-3"></i>
                                        <h5 class="text-secondary">No leads found</h5>
                                        <p class="text-secondary">All new leads will appear here</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card rounded-5 border-0 shadow-lg">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-bell me-2 text-tertiary"></i>
                    Recent Activity
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="timeline p-4">
                    <div class="timeline-item pb-4 position-relative ps-4 border-start border-tertiary">
                        <div class="timeline-badge position-absolute start-0 translate-middle-x rounded-circle bg-tertiary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-user-plus text-white fa-sm"></i>
                        </div>
                        <div class="timeline-content ps-3">
                            <h6 class="mb-1 fw-bold">New user registered</h6>
                            <p class="mb-1 small">Sarah Johnson signed up as a new customer.</p>
                            <span class="badge bg-tertiary bg-opacity-10 text-tertiary small">Just now</span>
                        </div>
                    </div>
                    
                    <div class="timeline-item pb-4 position-relative ps-4 border-start border-tertiary">
                        <div class="timeline-badge position-absolute start-0 translate-middle-x rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-dollar-sign text-white fa-sm"></i>
                        </div>
                        <div class="timeline-content ps-3">
                            <h6 class="mb-1 fw-bold">New sale completed</h6>
                            <p class="mb-1 small">Project #2589 was purchased by Acme Corp.</p>
                            <span class="badge bg-tertiary bg-opacity-10 text-tertiary small">3 hours ago</span>
                        </div>
                    </div>
                    
                    <div class="timeline-item pb-4 position-relative ps-4 border-start border-tertiary">
                        <div class="timeline-badge position-absolute start-0 translate-middle-x rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-user-tag text-white fa-sm"></i>
                        </div>
                        <div class="timeline-content ps-3">
                            <h6 class="mb-1 fw-bold">New lead created</h6>
                            <p class="mb-1 small">John Smith submitted contact form from homepage.</p>
                            <span class="badge bg-tertiary bg-opacity-10 text-tertiary small">Yesterday</span>
                        </div>
                    </div>
                    
                    <div class="timeline-item position-relative ps-4 border-start border-tertiary">
                        <div class="timeline-badge position-absolute start-0 translate-middle-x rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-comments text-white fa-sm"></i>
                        </div>
                        <div class="timeline-content ps-3">
                            <h6 class="mb-1 fw-bold">Client feedback received</h6>
                            <p class="mb-1 small">TechStart Inc. left a 5-star review on the project.</p>
                            <span class="badge bg-tertiary bg-opacity-10 text-tertiary small">3 days ago</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center border-0 pt-0 pb-4">
                <a href="#" class="btn btn-sm btn-outline-tertiary rounded-pill px-4">View All Activity</a>
            </div>
        </div>
    </div>
</div>

<!-- Project Status -->
<div class="row mt-4">
    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card rounded-5 border-0 shadow-lg h-100">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-chart-pie me-2 text-tertiary"></i>
                    Project Status
                </h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="chart-responsive mb-4">
                    <canvas id="projectStatusChart" height="220"></canvas>
                </div>
                <div class="mt-auto">
                    <div class="row gx-2 gy-2 text-center">
                        <div class="col">
                            <div class="p-3 rounded-4 bg-success bg-opacity-10">
                                <h5 class="mb-0 fw-bold">{{ $projectsByStatus['published'] }}</h5>
                                <small class="text-success">Published</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 rounded-4 bg-warning bg-opacity-10">
                                <h5 class="mb-0 fw-bold">{{ $projectsByStatus['draft'] }}</h5>
                                <small class="text-warning">Draft</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 rounded-4 bg-tertiary bg-opacity-10">
                                <h5 class="mb-0 fw-bold">{{ array_sum($projectsByStatus) }}</h5>
                                <small class="text-tertiary">Total</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Projects -->
<div class="row mt-4">
    <div class="col-12" data-aos="fade-up" data-aos-delay="100">
        <div class="card rounded-5 border-0 shadow-lg">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-project-diagram me-2 text-tertiary"></i>
                        Recent Projects
                    </h5>
                    <a href="{{ route('admin.portfolio.index') }}" class="btn btn-sm btn-tertiary rounded-pill">
                        View All
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($latestProjects as $project)
                    <div class="col-md-6 col-lg-4 mb-4" data-aos="zoom-in-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card bg-dark h-100 border-0 rounded-4 shadow">
                            <div class="position-relative">
                                @if($project->image_path)
                                    <img src="{{ asset('storage/' . $project->image_path) }}" 
                                         class="card-img-top rounded-top-4" alt="{{ $project->title }}"
                                         style="height: 160px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center rounded-top-4"
                                         style="height: 160px;">
                                        <i class="fas fa-image fa-3x text-secondary opacity-50"></i>
                                    </div>
                                @endif
                                
                                @if($project->featured)
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-warning px-2 py-1">
                                        <i class="fas fa-star me-1"></i> Featured
                                    </span>
                                </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-{{ $project->status === 'published' ? 'success' : 'secondary' }} rounded-pill px-3">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                    <span class="badge bg-info rounded-pill px-3">
                                        {{ ucfirst($project->category) }}
                                    </span>
                                </div>
                                <h5 class="card-title">{{ $project->title }}</h5>
                                <p class="card-text small text-secondary">
                                    {{ Str::limit($project->description, 80) }}
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ $project->created_at->format('M d, Y') }}
                                    </small>
                                    <a href="{{ route('admin.portfolio.edit', $project->id) }}" class="btn btn-sm btn-tertiary">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <div class="d-inline-block p-4 bg-light rounded-4 mb-3">
                            <i class="fas fa-project-diagram fa-3x text-secondary"></i>
                        </div>
                        <h4>No Projects Found</h4>
                        <p class="text-muted mb-4">Start adding projects to your portfolio</p>
                        <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Add First Project
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<style>
    /* Estilos adicionais para os botões de período */
    .period-selector-group .btn {
        transition: all 0.2s ease;
        position: relative;
        z-index: 1;
    }
    
    .period-selector-group .btn-tertiary {
        color: #fff !important;
        border-color: #e94cc8 !important;
        background-color: #e94cc8 !important;
        font-weight: 500;
    }
    
    .period-selector-group .btn-outline-tertiary {
        color: #e94cc8 !important;
        border-color: #e94cc8 !important;
        background-color: transparent !important;
    }
    
    .period-selector-group .btn-outline-tertiary:hover {
        background-color: rgba(233, 76, 200, 0.1) !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Chart objects reference
        let visitorChart;
        
        // Function to update metrics based on period
        function updateMetrics(data) {
            console.log('Updating metrics with data:', data);
            
            // First, restore metrics elements if they're in loading state
            restoreMetricsFromLoading();
            
            // If data has no metrics, exit but don't leave spinners
            if (!data || !data.metrics) {
                console.warn('No metrics data available to update cards');
                return;
            }
            
            // Helper function to find elements by text content
            function findElementByText(selector, text) {
                const elements = document.querySelectorAll(selector);
                for (let i = 0; i < elements.length; i++) {
                    if (elements[i].textContent.trim().includes(text)) {
                        return elements[i];
                    }
                }
                return null;
            }
            
            // Helper to restore original values if data is missing
            function restoreMetricsFromLoading() {
                // Get all metrics elements
                const metricElements = document.querySelectorAll('.p-3.rounded-4.bg-tertiary.bg-opacity-10 h4');
                
                // For each element with a spinner, restore the original value from the server
                metricElements.forEach(el => {
                    if (el.innerHTML.includes('spinner-border')) {
                        // Get original value from PHP-rendered HTML
                        // Total Views
                        if (el.previousElementSibling && el.previousElementSibling.textContent.includes('TOTAL VIEWS')) {
                            el.innerHTML = '{{ number_format($stats['views']) }}';
                        }
                        // Unique Visitors
                        else if (el.previousElementSibling && el.previousElementSibling.textContent.includes('UNIQ. VISITORS')) {
                            el.innerHTML = '{{ number_format($analyticsMetrics['totalVisitors']) }}';
                        }
                        // Bounce Rate
                        else if (el.previousElementSibling && el.previousElementSibling.textContent.includes('BOUNCE RATE')) {
                            el.innerHTML = '{{ number_format($analyticsMetrics['bounceRate'], 1) }}%';
                        }
                        // Avg Duration
                        else if (el.previousElementSibling && el.previousElementSibling.textContent.includes('AVG. DURATION')) {
                            el.innerHTML = '{{ floor($analyticsMetrics['avgSessionDuration'] / 60) }}m {{ $analyticsMetrics['avgSessionDuration'] % 60 }}s';
                        }
                    }
                });
            }
            
            try {
                const metrics = data.metrics;
                
                // Total Views - find using small text content
                const totalViewsLabel = findElementByText('.text-secondary.small', 'TOTAL VIEWS');
                if (totalViewsLabel) {
                    const totalViewsElement = totalViewsLabel.nextElementSibling;
                    if (totalViewsElement) {
                        if (metrics.pageViews !== undefined) {
                            totalViewsElement.innerHTML = number_format(metrics.pageViews);
                            
                            // Update growth badge
                            const growthBadge = totalViewsElement.nextElementSibling;
                            if (growthBadge && metrics.pageViewsGrowth !== undefined) {
                                const growth = metrics.pageViewsGrowth;
                                growthBadge.className = `badge bg-${growth > 0 ? 'success' : 'danger'} rounded-pill px-2`;
                                growthBadge.innerHTML = `${growth > 0 ? '+' : ''}${number_format(growth, 1)}%`;
                            }
                        } else {
                            // Restore original value if data missing
                            totalViewsElement.innerHTML = '{{ number_format($stats['views']) }}';
                        }
                    }
                }
                
                // Unique Visitors
                const visitorsLabel = findElementByText('.text-secondary.small', 'UNIQ. VISITORS');
                if (visitorsLabel) {
                    const visitorsElement = visitorsLabel.nextElementSibling;
                    if (visitorsElement) {
                        if (metrics.totalVisitors !== undefined) {
                            visitorsElement.innerHTML = number_format(metrics.totalVisitors);
                            
                            // Update growth badge
                            const growthBadge = visitorsElement.nextElementSibling;
                            if (growthBadge && metrics.visitorsGrowth !== undefined) {
                                const growth = metrics.visitorsGrowth;
                                growthBadge.className = `badge bg-${growth > 0 ? 'success' : 'danger'} rounded-pill px-2`;
                                growthBadge.innerHTML = `${growth > 0 ? '+' : ''}${number_format(growth, 1)}%`;
                            }
                        } else {
                            // Restore original value if data missing
                            visitorsElement.innerHTML = '{{ number_format($analyticsMetrics['totalVisitors']) }}';
                        }
                    }
                }
                
                // Bounce Rate
                const bounceLabel = findElementByText('.text-secondary.small', 'BOUNCE RATE');
                if (bounceLabel) {
                    const bounceElement = bounceLabel.nextElementSibling;
                    if (bounceElement) {
                        if (metrics.bounceRate !== undefined) {
                            bounceElement.innerHTML = `${number_format(metrics.bounceRate, 1)}%`;
                            
                            // Update growth badge
                            const growthBadge = bounceElement.nextElementSibling;
                            if (growthBadge && metrics.bounceRateGrowth !== undefined) {
                                const growth = metrics.bounceRateGrowth;
                                growthBadge.className = `badge bg-${growth < 0 ? 'success' : 'danger'} rounded-pill px-2`;
                                growthBadge.innerHTML = `${growth > 0 ? '+' : ''}${number_format(growth, 1)}%`;
                            }
                        } else {
                            // Restore original value if data missing
                            bounceElement.innerHTML = '{{ number_format($analyticsMetrics['bounceRate'], 1) }}%';
                        }
                    }
                }
                
                // Avg Duration
                const durationLabel = findElementByText('.text-secondary.small', 'AVG. DURATION');
                if (durationLabel) {
                    const durationElement = durationLabel.nextElementSibling;
                    if (durationElement) {
                        if (metrics.avgSessionDuration !== undefined) {
                            const duration = metrics.avgSessionDuration;
                            durationElement.innerHTML = `${Math.floor(duration / 60)}m ${duration % 60}s`;
                            
                            // Update growth badge
                            const growthBadge = durationElement.nextElementSibling;
                            if (growthBadge && metrics.durationGrowth !== undefined) {
                                const growth = metrics.durationGrowth;
                                growthBadge.className = `badge bg-${growth > 0 ? 'success' : 'danger'} rounded-pill px-2`;
                                growthBadge.innerHTML = `${growth > 0 ? '+' : ''}${number_format(growth, 1)}%`;
                            }
                        } else {
                            // Restore original value if data missing
                            durationElement.innerHTML = '{{ floor($analyticsMetrics['avgSessionDuration'] / 60) }}m {{ $analyticsMetrics['avgSessionDuration'] % 60 }}s';
                        }
                    }
                }
                
                // Update the top card metric (Page Views in the first stats row)
                const allHeadings = document.querySelectorAll('.col-lg-3 h3.fw-bold');
                if (allHeadings.length >= 4 && metrics.pageViews !== undefined) {
                    const pageViewsHeading = allHeadings[3]; // fourth card
                    if (pageViewsHeading) {
                        // First save any icon that might be there
                        const iconElement = pageViewsHeading.querySelector('i');
                        const iconHTML = iconElement ? iconElement.outerHTML : '';
                        
                        // Update the content
                        pageViewsHeading.innerHTML = number_format(metrics.pageViews);
                        
                        // Add back the icon if it was there
                        if (iconHTML) {
                            pageViewsHeading.innerHTML += ' ' + iconHTML;
                        }
                    }
                }
            } catch (error) {
                console.error('Error updating metrics:', error);
                // Make sure we don't leave spinners on error
                restoreMetricsFromLoading();
            }
        }
        
        // Format numbers with commas
        function number_format(number, decimals = 0) {
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            }).format(number);
        }
        
        // Register click handlers for period selector buttons
        document.querySelectorAll('.period-selector').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.period-selector').forEach(btn => {
                    btn.classList.remove('active');
                    btn.classList.remove('btn-tertiary');
                    btn.classList.add('btn-outline-tertiary');
                });
                
                // Add active class to clicked button
                this.classList.add('active', 'btn-tertiary');
                this.classList.remove('btn-outline-tertiary');
                
                // Get the period from data attribute
                const period = this.dataset.period;
                
                // Show loading indicator for metrics
                document.querySelectorAll('.p-3.rounded-4.bg-tertiary.bg-opacity-10 h4').forEach(el => {
                    el.innerHTML = '<div class="spinner-border spinner-border-sm text-tertiary" role="status"><span class="visually-hidden">Loading...</span></div>';
                });
                
                // Fetch data for the selected period and update both chart and metrics
                fetch(`{{ route('admin.dashboard.analytics') }}?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update chart
                        createVisitorChart(period, data);
                        
                        // Update metrics cards
                        updateMetrics(data);
                    })
                    .catch(error => {
                        console.error('Error fetching analytics data:', error);
                        document.querySelector('.chart-container').innerHTML = '<div class="alert alert-danger m-3">Error loading chart data. Please try again.</div>';
                    });
            });
        });
        
        // Set initial active class on Weekly button
        document.querySelector('.period-selector[data-period="7"]').classList.add('active');
        
        // Initialize chart with weekly data by default - modified to use the new approach
        fetch(`{{ route('admin.dashboard.analytics') }}?period=7`)
            .then(response => response.json())
            .then(data => {
                // Create initial chart
                createVisitorChart(7, data);
            })
            .catch(error => {
                console.error('Error fetching initial analytics data:', error);
                document.querySelector('.chart-container').innerHTML = '<div class="alert alert-danger m-3">Error loading chart data. Please try again.</div>';
            });

        // Create visitor chart with the data for current period
        function createVisitorChart(period = 7, preloadedData = null) {
            // Destroy existing chart if it exists
            if (visitorChart) {
                visitorChart.destroy();
            }
            
            // Show loading state if we don't have preloaded data
            if (!preloadedData) {
                document.querySelector('.chart-container').innerHTML = '<div class="d-flex justify-content-center align-items-center h-100"><div class="spinner-border text-tertiary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
                
                // Fetch data for the selected period
                fetch(`{{ route('admin.dashboard.analytics') }}?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        processChartData(data);
                        
                        // Update metrics cards
                        updateMetrics(data);
                    })
                    .catch(error => {
                        console.error('Error fetching analytics data:', error);
                        document.querySelector('.chart-container').innerHTML = '<div class="alert alert-danger m-3">Error loading chart data. Please try again.</div>';
                    });
            } else {
                // Use preloaded data
                processChartData(preloadedData);
            }
            
            // Function to process chart data and create chart
            function processChartData(data) {
                console.log('Analytics data received:', data);
                
                // Clear loading state
                document.querySelector('.chart-container').innerHTML = '<canvas id="visitorChart"></canvas>';
                
                // Create the chart with the new data
                const visitorCtx = document.getElementById('visitorChart').getContext('2d');
                const visitorGradient = visitorCtx.createLinearGradient(0, 0, 0, 300);
                visitorGradient.addColorStop(0, 'rgba(233, 76, 200, 0.5)');  // tertiary color with opacity
                visitorGradient.addColorStop(1, 'rgba(233, 76, 200, 0)');
                
                // Process data for the chart
                let visitorData = data.visitorData;
                
                // Determine the current day based on the data
                const correctOrder = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                const currentDay = '{{ now()->format("D") }}';
                const currentDayIndex = correctOrder.indexOf(currentDay);
                
                // Process data differently based on the period
                if (period == 7) {
                    // For weekly data, use the same processing as before
                    // Ensure data is in correct order and null for future days
                    const processedData = correctOrder.map((day, index) => {
                        // Find existing data for this day
                        const found = visitorData.find(item => item.date === day);
                        
                        // If it's a future day, use null to break the line
                        if (index > currentDayIndex) {
                            return { 
                                date: day, 
                                visitors: null,
                                pageViews: null,
                                isFuture: true 
                            };
                        }
                        
                        // For days up to current, use found data or zeros
                        return found || { date: day, visitors: 0, pageViews: 0, isFuture: false };
                    });
                    
                    visitorData = processedData;
                } else {
                    // For monthly/yearly data, ensure data is valid for visualization
                    console.log('Original data for period ' + period + ':', visitorData);
                    
                    // Check if we have enough data
                    if (visitorData.length <= 1) {
                        console.warn('Insufficient data for visualization ' + period);
                        document.querySelector('.chart-container').innerHTML = '<div class="alert alert-warning m-3">Insufficient data for this period. Please try another period.</div>';
                        return;
                    }
                    
                    // Ensure all items have date and values
                    visitorData = visitorData.map(item => {
                        // If date is missing or null, log error and exclude
                        if (!item.date) {
                            console.warn('Item without date found:', item);
                            return null;
                        }
                        
                        // Check if it's a future date
                        let isFuture = false;
                        if (item.fullDate) {
                            const itemDate = new Date(item.fullDate);
                            const today = new Date();
                            today.setHours(0, 0, 0, 0);
                            isFuture = itemDate > today;
                        }
                        
                        // Always return valid object with real values (never null)
                        return {
                            ...item,
                            date: item.date,
                            visitors: Number(item.visitors || 0),
                            pageViews: Number(item.pageViews || 0),
                            isFuture: isFuture
                        };
                    }).filter(item => item !== null); // Remove null items
                    
                    // Sort by ascending date (important for continuous lines)
                    if (visitorData[0]?.fullDate) {
                        visitorData.sort((a, b) => {
                            return new Date(a.fullDate) - new Date(b.fullDate);
                        });
                    }
                    
                    console.log('Processed data for visualization:', visitorData);
                }
                
                // Create the chart
                visitorChart = new Chart(visitorCtx, {
                    type: 'line',
                    data: {
                        labels: visitorData.map(item => item.date),
                        datasets: [{
                            label: 'Visitors',
                            data: visitorData.map(item => period == 7 ? item.visitors : Number(item.visitors)),
                            backgroundColor: visitorGradient,
                            borderColor: '#e94cc8', // tertiary color
                            borderWidth: 3,
                            tension: 0.3,
                            pointBackgroundColor: function(context) {
                                const index = context.dataIndex;
                                if (period == 7) {
                                    return visitorData[index].isFuture ? 'rgba(200, 200, 200, 0.2)' : '#e94cc8';
                                } 
                                return visitorData[index].isFuture ? 'rgba(233, 76, 200, 0.4)' : '#e94cc8';
                            },
                            pointBorderColor: function(context) {
                                const index = context.dataIndex;
                                if (period == 7) {
                                    return visitorData[index].isFuture ? 'rgba(200, 200, 200, 0.2)' : '#fff';
                                }
                                return visitorData[index].isFuture ? 'rgba(255, 255, 255, 0.8)' : '#fff';
                            },
                            pointBorderWidth: 2,
                            pointRadius: function(context) {
                                const index = context.dataIndex;
                                return period == 7 && visitorData[index].isFuture ? 3 : 4;
                            },
                            pointHoverRadius: function(context) {
                                const index = context.dataIndex;
                                return period == 7 && visitorData[index].isFuture ? 4 : 6;
                            },
                            fill: true,
                            spanGaps: true // Always connect points
                        }, {
                            label: 'Page Views',
                            data: visitorData.map(item => period == 7 ? item.pageViews : Number(item.pageViews)),
                            backgroundColor: 'rgba(23, 162, 184, 0.2)', // info color with opacity
                            borderColor: '#17a2b8', // info color
                            borderWidth: 3,
                            tension: 0.3,
                            pointBackgroundColor: function(context) {
                                const index = context.dataIndex;
                                if (period == 7) {
                                    return visitorData[index].isFuture ? 'rgba(200, 200, 200, 0.2)' : '#17a2b8';
                                }
                                return visitorData[index].isFuture ? 'rgba(23, 162, 184, 0.4)' : '#17a2b8';
                            },
                            pointBorderColor: function(context) {
                                const index = context.dataIndex;
                                if (period == 7) {
                                    return visitorData[index].isFuture ? 'rgba(200, 200, 200, 0.2)' : '#fff';
                                }
                                return visitorData[index].isFuture ? 'rgba(255, 255, 255, 0.8)' : '#fff';
                            },
                            pointBorderWidth: 2,
                            pointRadius: function(context) {
                                const index = context.dataIndex;
                                return period == 7 && visitorData[index].isFuture ? 3 : 4;
                            },
                            pointHoverRadius: function(context) {
                                const index = context.dataIndex;
                                return period == 7 && visitorData[index].isFuture ? 4 : 6;
                            },
                            fill: true,
                            spanGaps: true // Always connect points
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 8
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                padding: 10,
                                cornerRadius: 6,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                caretSize: 6,
                                caretPadding: 8
                            }
                        },
                        elements: {
                            line: {
                                tension: 0.3,
                                borderWidth: 3,
                                fill: true,
                                cubicInterpolationMode: 'monotone' // Improves line interpolation
                            },
                            point: {
                                radius: 4,
                                hitRadius: 10,
                                hoverRadius: 6
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)',
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    },
                                    padding: 8
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    },
                                    padding: 8
                                }
                            }
                        }
                    }
                });
            }
        }

        // Create lead status chart with improved styling
        var leadStatusData = @json($leadsByStatus);
        var leadStatusCtx = document.getElementById('leadStatusChart').getContext('2d');
        var leadStatusChart = new Chart(leadStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['New', 'Contacted', 'Qualified', 'Converted', 'Closed'],
                datasets: [{
                    data: [
                        leadStatusData.new || 0,
                        leadStatusData.contacted || 0,
                        leadStatusData.qualified || 0, 
                        leadStatusData.converted || 0,
                        leadStatusData.closed || 0
                    ],
                    backgroundColor: [
                        '#28a745', // success
                        '#007bff', // primary
                        '#17a2b8', // info
                        '#ffc107', // warning
                        '#6c757d'  // secondary
                    ],
                    borderWidth: 0,
                    hoverOffset: 5,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        padding: 10,
                        cornerRadius: 6,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let sum = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = Math.round((value / sum) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Project Status Chart
        const projectStatusCtx = document.getElementById('projectStatusChart').getContext('2d');
        const projectStatusChart = new Chart(projectStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Published', 'Draft'],
                datasets: [{
                    data: [
                        {{ $projectsByStatus['published'] }},
                        {{ $projectsByStatus['draft'] }}
                    ],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#343a40'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection 