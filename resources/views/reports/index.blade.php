@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-chart-bar me-3 text-success"></i>Reports Dashboard</h1>
        <p class="text-muted mb-0">Overview and analytical reports for your fleet management system.</p>
    </div>
    {{-- Download All Reports Button Group (visible only to authorized users) --}}
    @can('download-reports')
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-download me-2"></i>Download Reports
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('reports.clients.download') }}">Clients Report (CSV)</a></li>
        <li><a class="dropdown-item" href="{{ route('reports.contracts.download') }}">Contracts Report (CSV)</a></li>
        <li><a class="dropdown-item" href="{{ route('reports.installations.download') }}">Installations Report (CSV)</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="{{ route('reports.contracts_by_service_type.download') }}">Contracts by Service Type (CSV)</a></li>
    </ul>
</div>
@endcan
</div>

<div class="row">
    {{-- Clients Overview --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 border-start border-success border-5">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase text-success mb-2">Total Clients</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $totalClients }}</h2>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-1">{{ $activeClients }} Active</span> /
                            <span class="text-danger ms-1">{{ $inactiveClients }} Inactive</span>
                        </p>
                    </div>
                    <i class="fas fa-users fa-3x text-success text-opacity-25"></i>
                </div>
            </div>
            <div class="card-footer bg-light border-0">
                <a href="{{ route('clients.index') }}" class="text-success text-decoration-none small">View Clients <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    {{-- Contracts Overview --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 border-start border-primary border-5">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase text-primary mb-2">Total Contracts</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $totalContracts }}</h2>
                        <p class="mb-0 text-muted">
                            <span class="text-primary me-1">{{ $activeContracts }} Active</span> /
                            <span class="text-danger mx-1">{{ $expiredContracts }} Expired</span> /
                            <span class="text-warning ms-1">{{ $contractsExpiringSoon }} Expiring Soon</span>
                        </p>
                    </div>
                    <i class="fas fa-file-contract fa-3x text-primary text-opacity-25"></i>
                </div>
            </div>
            <div class="card-footer bg-light border-0">
                <a href="{{ route('contracts.index') }}" class="text-primary text-decoration-none small">View Contracts <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    {{-- Installations Overview --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 border-start border-info border-5">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-uppercase text-info mb-2">Total Installations</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $totalInstallations }}</h2>
                        <p class="mb-0 text-muted">
                            <span class="text-warning me-1">{{ $pendingInstallations }} Pending</span> /
                            <span class="text-success mx-1">{{ $completedInstallations }} Completed</span> /
                            <span class="text-danger ms-1">{{ $cancelledInstallations }} Cancelled</span>
                        </p>
                    </div>
                    <i class="fas fa-tools fa-3x text-info text-opacity-25"></i>
                </div>
            </div>
            <div class="card-footer bg-light border-0">
                <a href="{{ route('installations.index') }}" class="text-info text-decoration-none small">View Installations <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Contracts by Service Type --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Contracts by Service Type</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($contractsByServiceType as $serviceType)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $serviceType->name }}
                            <span class="badge bg-primary rounded-pill">{{ $serviceType->contractServices_count }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No service types found with contracts.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    {{-- Installations by Status --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Installations by Status</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($installationsByStatus as $statusReport)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ ucfirst($statusReport->status) }}
                            @php
                                $statusBadgeClass = '';
                                switch($statusReport->status) {
                                    case 'pending': $statusBadgeClass = 'bg-warning'; break;
                                    case 'completed': $statusBadgeClass = 'bg-success'; break;
                                    case 'cancelled': $statusBadgeClass = 'bg-danger'; break;
                                    default: $statusBadgeClass = 'bg-secondary'; break;
                                }
                            @endphp
                            <span class="badge {{ $statusBadgeClass }} rounded-pill">{{ $statusReport->count }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No installations found.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
