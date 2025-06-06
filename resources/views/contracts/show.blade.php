@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-file-contract me-3 text-primary"></i>Contract: {{ $contract->contract_number }}</h1>
        <p class="text-muted mb-0">Contract Details for {{ $contract->client->company_name ?? 'N/A' }}</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit Contract
        </a>
        <a href="{{ route('contracts.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Contracts
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Contract Overview</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">Contract Number</strong>
                    <span>{{ $contract->contract_number }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">Client</strong>
                    <span>
                        @if($contract->client)
                            <a href="{{ route('clients.show', $contract->client) }}" class="text-decoration-none">
                                {{ $contract->client->company_name }}
                            </a>
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">Start Date</strong>
                    <span>{{ $contract->start_date->format('M d, Y') }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">End Date</strong>
                    <span>{{ $contract->end_date->format('M d, Y') }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">Total Installation Cost</strong>
                    <span>{{ $contract->currency }} {{ number_format($contract->total_installation_cost, 2) }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">Monthly Cost</strong>
                    <span>{{ $contract->currency }} {{ number_format($contract->monthly_cost, 2) }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-muted d-block mb-1">Status</strong>
                    @php
                        $now = now();
                        $status = 'active';
                        $statusClass = 'success';

                        if($contract->start_date > $now) {
                            $status = 'pending';
                            $statusClass = 'warning';
                        } elseif($contract->end_date < $now) {
                            $status = 'expired';
                            $statusClass = 'danger';
                        }
                    @endphp
                    <span class="badge bg-{{ $statusClass }}">{{ ucfirst($status) }}</span>
                </div>
                <hr>
                <div class="small text-muted">
                    <p class="mb-1"><strong>Created:</strong> {{ $contract->created_at->format('M d, Y H:i A') }}</p>
                    <p class="mb-0"><strong>Last Updated:</strong> {{ $contract->updated_at->format('M d, Y H:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Services Included ({{ $contract->contractServices->count() }})</h5>
            </div>
            <div class="card-body p-0">
                @if($contract->contractServices->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Service Type</th>
                                    <th>Quantity</th>
                                    <th>Unit Inst. Price</th>
                                    <th>Total Inst. Cost</th>
                                    <th>Unit Monthly Price</th>
                                    <th>Total Monthly Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contract->contractServices as $service)
                                    <tr>
                                        <td>{{ $service->serviceType->name ?? 'N/A' }}</td>
                                        <td>{{ $service->quantity }}</td>
                                        <td>{{ $contract->currency }} {{ number_format($service->unit_installation_price, 2) }}</td>
                                        <td>{{ $contract->currency }} {{ number_format($service->total_installation_cost, 2) }}</td>
                                        <td>{{ $contract->currency }} {{ number_format($service->unit_monthly_price, 2) }}</td>
                                        <td>{{ $contract->currency }} {{ number_format($service->total_monthly_cost, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">No services defined for this contract.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-tools me-2"></i>Installations ({{ $contract->installations->count() }})</h5>
                @if($contract->installations->count() > 0)
                    {{-- Assuming you might want to link to create installation here --}}
                    <a href="{{ route('installations.create', ['contract_id' => $contract->id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>New Installation
                    </a>
                @endif
            </div>
            <div class="card-body p-0">
                @if($contract->installations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Installation ID</th>
                                    <th>Vehicle</th>
                                    <th>Technician</th>
                                    <th>Installation Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contract->installations as $installation)
                                    <tr>
                                        <td><strong>#{{ $installation->id }}</strong></td>
                                        <td>{{ $installation->vehicle->plate_number ?? 'N/A' }}</td>
                                        <td>{{ $installation->technician->name ?? 'N/A' }}</td>
                                        <td>{{ $installation->installation_date->format('M d, Y') }}</td>
                                        <td>
                                            @php
                                                $installationStatusClass = '';
                                                switch($installation->status) {
                                                    case 'pending': $installationStatusClass = 'warning'; break;
                                                    case 'completed': $installationStatusClass = 'success'; break;
                                                    case 'cancelled': $installationStatusClass = 'danger'; break;
                                                    default: $installationStatusClass = 'secondary'; break;
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $installationStatusClass }}">{{ ucfirst($installation->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('installations.show', $installation) }}" class="btn btn-outline-info" title="View Installation">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('installations.edit', $installation) }}" class="btn btn-outline-warning" title="Edit Installation">
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
                        <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Installations Recorded</h5>
                        <p class="text-muted mb-4">There are no installations associated with this contract yet.</p>
                        <a href="{{ route('installations.create', ['contract_id' => $contract->id]) }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Record New Installation
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
