@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-file-contract me-3 text-primary"></i>Contracts</h1>
        <p class="text-muted mb-0">Manage all client contracts</p>
    </div>
    <a href="{{ route('contracts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Contract
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Contract List</h5>
        <form class="d-flex" role="search" method="GET" action="{{ route('contracts.index') }}">
            <input class="form-control me-2" type="search" placeholder="Search contracts..." aria-label="Search" name="search" value="{{ request('search') }}">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    <div class="card-body p-0">
        @if($contracts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Contract Number</th>
                            <th scope="col">Client</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Monthly Cost</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contracts as $contract)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('contracts.show', $contract) }}" class="text-decoration-none"><strong>{{ $contract->contract_number }}</strong></a></td>
                                <td>
                                    <a href="{{ route('clients.show', $contract->client) }}" class="text-decoration-none">
                                        {{ $contract->client->company_name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>{{ $contract->start_date->format('M d, Y') }}</td>
                                <td>{{ $contract->end_date->format('M d, Y') }}</td>
                                <td>{{ $contract->currency }} {{ number_format($contract->monthly_cost, 2) }}</td>
                                <td>
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
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('contracts.show', $contract) }}" class="btn btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('contracts.destroy', $contract) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contract? This action cannot be undone.');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white pt-3">
                {{ $contracts->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-file-contract fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No Contracts Found</h5>
                <p class="text-muted mb-4">It looks like there are no contracts to display yet. Start by adding a new one!</p>
                <a href="{{ route('contracts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Contract
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
