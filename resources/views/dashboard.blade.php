@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0" style="color: #333; font-weight: 600;">Dashboard</h1>
    <div class="text-muted">
        <i class="fas fa-clock me-1"></i>{{ date('F j, Y') }}
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1" style="font-size: 0.9rem; opacity: 0.9;">Total Clients</h5>
                        <h2 class="mb-0" style="font-weight: 700;">{{ $totalClients ?? 0 }}</h2>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-users fa-2x" style="opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1" style="font-size: 0.9rem; opacity: 0.9;">Active Contracts</h5>
                        <h2 class="mb-0" style="font-weight: 700;">{{ $activeContracts ?? 0 }}</h2>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-file-contract fa-2x" style="opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1" style="font-size: 0.9rem; opacity: 0.9;">Pending Installations</h5>
                        <h2 class="mb-0" style="font-weight: 700;">{{ $pendingInstallations ?? 0 }}</h2>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-tools fa-2x" style="opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1" style="font-size: 0.9rem; opacity: 0.9;">Monthly Revenue</h5>
                        <h2 class="mb-0" style="font-weight: 700;">{{ number_format($monthlyRevenue ?? 0, 0) }}</h2>
                        <small style="opacity: 0.8;">TZS</small>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-money-bill-wave fa-2x" style="opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="padding: 1.5rem 1.5rem 0;">
                <h5 class="mb-0" style="color: #333; font-weight: 600;">
                    <i class="fas fa-bolt me-2" style="color: #667eea;"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body" style="padding: 1rem 1.5rem 1.5rem;">
                <div class="d-grid gap-2">
                    <a href="{{ route('clients.create') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-start" style="padding: 12px 16px; border-radius: 8px;">
                        <i class="fas fa-plus-circle me-3" style="color: #667eea;"></i>
                        <span>Add New Client</span>
                    </a>
                    <a href="{{ route('contracts.create') }}" class="btn btn-outline-success d-flex align-items-center justify-content-start" style="padding: 12px 16px; border-radius: 8px;">
                        <i class="fas fa-file-plus me-3" style="color: #11998e;"></i>
                        <span>Create Contract</span>
                    </a>
                    <a href="{{ route('installations.create') }}" class="btn btn-outline-info d-flex align-items-center justify-content-start" style="padding: 12px 16px; border-radius: 8px;">
                        <i class="fas fa-calendar-plus me-3" style="color: #4facfe;"></i>
                        <span>Schedule Installation</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="padding: 1.5rem 1.5rem 0;">
                <h5 class="mb-0" style="color: #333; font-weight: 600;">
                    <i class="fas fa-chart-line me-2" style="color: #667eea;"></i>System Overview
                </h5>
            </div>
            <div class="card-body" style="padding: 1rem 1.5rem 1.5rem;">
                <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-contract me-2" style="color: #11998e;"></i>
                            <span style="font-weight: 500;">Active Contracts</span>
                        </div>
                        <span class="badge bg-success" style="padding: 6px 12px;">{{ $activeContracts ?? 0 }}</span>
                    </div>
                </div>

                <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-tools me-2" style="color: #f5576c;"></i>
                            <span style="font-weight: 500;">Pending Installations</span>
                        </div>
                        <span class="badge bg-warning" style="padding: 6px 12px;">{{ $pendingInstallations ?? 0 }}</span>
                    </div>
                </div>

                <div class="p-3 rounded" style="background: #f8f9fa;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-money-bill-wave me-2" style="color: #4facfe;"></i>
                            <span style="font-weight: 500;">Monthly Revenue</span>
                        </div>
                        <span class="badge bg-info" style="padding: 6px 12px;">{{ number_format($monthlyRevenue ?? 0, 0) }} TZS</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="padding: 1.5rem 1.5rem 0;">
                <h5 class="mb-0" style="color: #333; font-weight: 600;">
                    <i class="fas fa-clock me-2" style="color: #667eea;"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body" style="padding: 1rem 1.5rem 1.5rem;">
                <div class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                    <p class="mb-0">No recent activity to display</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
