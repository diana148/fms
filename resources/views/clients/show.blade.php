@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-user me-3 text-primary"></i>{{ $client->company_name }}</h1>
        <p class="text-muted mb-0">Client Details & Contract Information</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit Client
        </a>
        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Clients
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-building me-2"></i>Client Information</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="avatar-lg bg-primary-soft rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                        <i class="fas fa-building fa-2x text-primary"></i>
                    </div>
                    <h4 class="mb-1">{{ $client->company_name }}</h4>
                    <p class="text-muted">Client ID: #{{ $client->id }}</p>
                </div>

                <hr>

                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">Contact Person</strong>
                    <span>{{ $client->contact_person }}</span>
                </div>

                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">Email</strong>
                    <a href="mailto:{{ $client->email }}" class="text-decoration-none">
                        <i class="fas fa-envelope me-1"></i>{{ $client->email }}
                    </a>
                </div>

                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">Phone</strong>
                    <a href="tel:{{ $client->phone }}" class="text-decoration-none">
                        <i class="fas fa-phone me-1"></i>{{ $client->phone }}
                    </a>
                </div>

                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">Address</strong>
                    <span>{{ $client->address }}</span>
                </div>

                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">Number of Vehicles</strong>
                    <span class="badge bg-info">{{ $client->number_of_vehicles }} vehicles</span>
                </div>

                <hr>

                <div class="small text-muted">
                    <p class="mb-1"><strong>Created:</strong> {{ $client->created_at->format('M d, Y') }}</p>
                    <p class="mb-0"><strong>Last Updated:</strong> {{ $client->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-file-contract me-2"></i>Contracts ({{ $client->contracts->count() }})</h5>
                @if($client->contracts->count() > 0)
                    <a href="{{ route('contracts.create', ['client_id' => $client->id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>New Contract
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($client->contracts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Contract #</th>
                                    <th>Services</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($client->contracts as $contract)
                                <tr>
                                    <td>
                                        <strong>#{{ $contract->id }}</strong>
                                    </td>
                                    <td>
                                        @if($contract->contractServices->count() > 0)
                                            @foreach($contract->contractServices->take(2) as $service)
                                                <span class="badge bg-secondary me-1">{{ $service->serviceType->name ?? 'N/A' }}</span>
                                            @endforeach
                                            @if($contract->contractServices->count() > 2)
                                                <span class="badge bg-light text-dark">+{{ $contract->contractServices->count() - 2 }} more</span>
                                            @endif
                                        @else
                                            <span class="text-muted">No services</span>
                                        @endif
                                    </td>
                                    <td>{{ $contract->start_date ? $contract->start_date->format('M d, Y') : 'N/A' }}</td>
                                    <td>{{ $contract->end_date ? $contract->end_date->format('M d, Y') : 'N/A' }}</td>
                                    <td>
                                        @php
                                            $now = now();
                                            $status = 'active';
                                            $statusClass = 'success';

                                            if($contract->start_date && $contract->start_date > $now) {
                                                $status = 'pending';
                                                $statusClass = 'warning';
                                            } elseif($contract->end_date && $contract->end_date < $now) {
                                                $status = 'expired';
                                                $statusClass = 'danger';
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">{{ ucfirst($status) }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('contracts.show', $contract) }}" class="btn btn-outline-primary" title="View Contract">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-outline-warning" title="Edit Contract">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-contract fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Contracts Found</h5>
                        <p class="text-muted mb-4">This client doesn't have any contracts yet.</p>
                        <a href="{{ route('contracts.create', ['client_id' => $client->id]) }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create First Contract
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-file-contract fa-2x mb-2"></i>
                        <h4 class="mb-0">{{ $client->contracts->count() }}</h4>
                        <small>Total Contracts</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h4 class="mb-0">{{ $client->contracts->where('end_date', '>', now())->count() }}</h4>
                        <small>Active Contracts</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-car fa-2x mb-2"></i>
                        <h4 class="mb-0">{{ $client->number_of_vehicles }}</h4>
                        <small>Vehicles on Contract</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
