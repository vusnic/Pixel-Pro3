@extends('layouts.admin')

@section('title', 'Leads - Pxp3 Admin')

@section('header', 'Leads')

@section('breadcrumb')
<li class="breadcrumb-item active">Leads</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card rounded-5 border-0 shadow-lg">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-users me-2 text-tertiary"></i>
                        Manage Leads
                    </h5>
                    <div class="d-flex gap-2">
                        <button onclick="exportToPdf()" class="btn btn-outline-tertiary rounded-pill text-light">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </button>
                        <a href="https://wa.me/558394172543?text=Hello%20Carlos%2C%20i%20need%20more%20leads!" class="btn btn-tertiary rounded-pill text-light">
                            <i class="fas fa-plus me-1"></i> Get More Leads
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

                <div class="mb-4">
                    <form action="{{ route('admin.leads.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control bg-white" placeholder="Search leads..." value="{{ request('search') }}">
                                <button class="btn btn-tertiary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select bg-white" onChange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="qualified" {{ request('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                                <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="source" class="form-select bg-white" onChange="this.form.submit()">
                                <option value="">All Sources</option>
                                <option value="homepage" {{ request('source') == 'homepage' ? 'selected' : '' }}>Homepage</option>
                                <option value="contact" {{ request('source') == 'contact' ? 'selected' : '' }}>Contact</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>
                
                @if($leads->isEmpty())
                <div class="text-center py-5">
                    <div class="d-inline-block p-4 bg-light rounded-4 mb-3">
                        <i class="fas fa-users fa-3x text-secondary"></i>
                    </div>
                    <h4>No Leads Found</h4>
                    <p class="text-muted mb-4">No leads have been registered yet</p>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px">ID</th>
                                <th style="width: 50px">Avatar</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leads as $lead)
                                <tr>
                                    <td>{{ $lead->id }}</td>
                                    <td>
                                        <img src="https://ui-avatars.com/api/?name={{ $lead->name }}&background=random&color=fff&size=32" 
                                            class="rounded-circle" alt="{{ $lead->name }}" width="32" height="32">
                                    </td>
                                    <td>{{ $lead->name }}</td>
                                    <td>{{ $lead->email }}</td>
                                    <td>{{ $lead->full_phone }}</td>
                                    <td>
                                        <span class="badge rounded-pill {{ $lead->source === 'homepage' ? 'bg-primary' : 'bg-info' }} bg-opacity-50">
                                            {{ ucfirst($lead->source) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($lead->status === 'new')
                                            <span class="badge bg-success rounded-pill px-3 py-2 bg-opacity-50">New</span>
                                        @elseif ($lead->status === 'contacted')
                                            <span class="badge bg-primary rounded-pill px-3 py-2 bg-opacity-50">Contacted</span>
                                        @elseif ($lead->status === 'qualified')
                                            <span class="badge bg-info rounded-pill px-3 py-2 bg-opacity-50">Qualified</span>
                                        @elseif ($lead->status === 'converted')
                                            <span class="badge bg-warning rounded-pill px-3 py-2 bg-opacity-50 text-dark">Converted</span>
                                        @elseif ($lead->status === 'closed')
                                            <span class="badge bg-secondary rounded-pill px-3 py-2 bg-opacity-50">Closed</span>
                                        @endif
                                    </td>
                                    <td>{{ $lead->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-light" 
                                                    onclick="return confirm('Are you sure you want to delete this lead?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No leads found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $leads->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function exportToPdf() {
    // Get current filter values
    const searchValue = document.querySelector('input[name="search"]').value;
    const statusValue = document.querySelector('select[name="status"]').value;
    const sourceValue = document.querySelector('select[name="source"]').value;
    
    // Build URL with current filters
    let url = '{{ route("admin.leads.export-pdf") }}';
    const params = new URLSearchParams();
    
    if (searchValue) params.append('search', searchValue);
    if (statusValue) params.append('status', statusValue);
    if (sourceValue) params.append('source', sourceValue);
    
    if (params.toString()) {
        url += '?' + params.toString();
    }
    
    // Open in new window/tab
    window.open(url, '_blank', 'width=1200,height=800,scrollbars=yes,resizable=yes');
}
</script>

@endsection 