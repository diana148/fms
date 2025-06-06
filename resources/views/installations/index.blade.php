@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-tools me-3 text-info"></i>Installations</h1>
        <p class="text-muted mb-0">Manage client service installations.</p>
    </div>
    <a href="{{ route('installations.create') }}" class="btn btn-info text-white">
        <i class="fas fa-plus-circle me-2"></i>Schedule New Installation
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Installations</h5>
    </div>
    <div class="card-body">
        @if($installations->isEmpty())
            <div class="alert alert-info text-center" role="alert">
                No installations found. Click "Schedule New Installation" to add one!
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Contract/Client</th>
                            <th scope="col">Service Type</th>
                            <th scope="col">Plate Number</th>
                            <th scope="col">Device SN</th>
                            <th scope="col">Date</th>
                            <th scope="col">Technician</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($installations as $installation)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>
                                @if($installation->contract)
                                    <a href="{{ route('contracts.show', $installation->contract) }}" class="text-decoration-none">
                                        {{ $installation->contract->contract_number }} ({{ $installation->contract->client->company_name ?? 'N/A' }})
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $installation->serviceType->name ?? 'N/A' }}</td>
                            <td>{{ $installation->vehicle_plate_number }}</td>
                            <td>{{ $installation->device_serial_number ?? 'N/A' }}</td>
                            <td>{{ $installation->installation_date->format('M d, Y') }}</td>
                            <td>{{ $installation->technician->name ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $statusClass = '';
                                    switch($installation->status) {
                                        case 'scheduled': $statusClass = 'badge bg-warning'; break;
                                        case 'completed': $statusClass = 'badge bg-success'; break;
                                        case 'failed': $statusClass = 'badge bg-danger'; break;
                                        default: $statusClass = 'badge bg-secondary'; break;
                                    }
                                @endphp
                                <span class="{{ $statusClass }}">{{ ucfirst($installation->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('installations.edit', $installation) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('installations.destroy', $installation) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this installation record?');">
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
            <div class="mt-3">
                {{ $installations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
