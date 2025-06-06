@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-user me-3 text-secondary"></i>User Details: {{ $user->name }}</h1>
        <p class="text-muted mb-0">Detailed information about the user.</p>
    </div>
    <div>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Back to Users List
        </a>
        @can('manage-users')
            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning text-white">
                <i class="fas fa-edit me-2"></i>Edit User
            </a>
        @endcan
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4"><strong>Name:</strong></div>
            <div class="col-md-8">{{ $user->name }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Email:</strong></div>
            <div class="col-md-8">{{ $user->email }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Role:</strong></div>
            <div class="col-md-8">
                <span class="badge bg-{{ $user->isAdmin() ? 'danger' : ($user->isManager() ? 'info' : ($user->isTechnician() ? 'primary' : 'secondary')) }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Status:</strong></div>
            <div class="col-md-8">
                @if($user->is_active)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-warning">Inactive</span>
                @endif
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Created At:</strong></div>
            <div class="col-md-8">{{ $user->created_at->format('M d, Y H:i A') }}</div>
        </div>
        <div class="row">
            <div class="col-md-4"><strong>Last Updated:</strong></div>
            <div class="col-md-8">{{ $user->updated_at->format('M d, Y H:i A') }}</div>
        </div>
    </div>
</div>

{{-- You might want to display installations managed by this technician, if applicable --}}
@if($user->isTechnician() && $user->installations->isNotEmpty())
<div class="card shadow-sm">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0"><i class="fas fa-tools me-2"></i>Managed Installations</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Client</th>
                        <th scope="col">Service Type</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Contract No.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->installations as $installation)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $installation->client->company_name ?? 'N/A' }}</td>
                        <td>{{ $installation->serviceType->name ?? 'N/A' }}</td>
                        <td>{{ $installation->installation_date->format('Y-m-d') }}</td>
                        <td>
                            @php
                                $statusBadgeClass = '';
                                switch($installation->status) {
                                    case 'pending': $statusBadgeClass = 'bg-warning'; break;
                                    case 'completed': $statusBadgeClass = 'bg-success'; break;
                                    case 'cancelled': $statusBadgeClass = 'bg-danger'; break;
                                    default: $statusBadgeClass = 'bg-secondary'; break;
                                }
                            @endphp
                            <span class="badge {{ $statusBadgeClass }}">{{ ucfirst($installation->status) }}</span>
                        </td>
                        <td>{{ $installation->contract->contract_number ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@elseif($user->isTechnician())
<div class="alert alert-info text-center mt-4">
    This technician is not currently assigned to any installations.
</div>
@endif

@endsection
