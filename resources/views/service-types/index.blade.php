@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-cogs me-3 text-primary"></i>Service Types</h1>
        <p class="text-muted mb-0">Manage the types of services your company offers.</p>
    </div>
    <a href="{{ route('service-types.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Add New Service Type
    </a>
</div>

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

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Service Types</h5>
    </div>
    <div class="card-body">
        @if($serviceTypes->isEmpty())
            <div class="alert alert-info text-center" role="alert">
                No service types found. Click "Add New Service Type" to get started!
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Inst. Price (TZS)</th>
                            <th scope="col">Monthly Price (TZS)</th>
                            <th scope="col">Inst. Price (USD)</th>
                            <th scope="col">Monthly Price (USD)</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($serviceTypes as $serviceType)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $serviceType->name }}</td>
                            <td>{{ Str::limit($serviceType->description, 50, '...') ?? 'N/A' }}</td>
                            <td>{{ number_format($serviceType->installation_price_tzs, 2) }}</td>
                            <td>{{ number_format($serviceType->monthly_price_tzs, 2) }}</td>
                            <td>{{ number_format($serviceType->installation_price_usd, 2) }}</td>
                            <td>{{ number_format($serviceType->monthly_price_usd, 2) }}</td>
                            <td>
                                @if($serviceType->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('service-types.edit', $serviceType) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('service-types.destroy', $serviceType) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service type? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
