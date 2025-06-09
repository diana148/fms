@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-file-invoice-dollar me-3 text-primary"></i>Invoices</h1>
        <p class="text-muted mb-0">Manage and generate monthly invoices for active contracts.</p>
    </div>
    <form action="{{ route('invoices.generate') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-receipt me-2"></i>Generate Monthly Invoices
        </button>
    </form>
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

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Client</th>
                        <th>Contract #</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->client->company_name ?? 'N/A' }}</td>
                            <td>{{ $invoice->contract->contract_number ?? 'N/A' }}</td>
                            <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                            <td>{{ $invoice->due_date->format('Y-m-d') }}</td>
                            <td>
                                @if($invoice->amount_tzs > 0)
                                    TZS {{ number_format($invoice->amount_tzs, 2) }}
                                @else
                                    USD {{ number_format($invoice->amount_usd, 2) }}
                                @endif
                            </td>
                            <td><span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'overdue' ? 'danger' : 'warning') }}">{{ ucfirst($invoice->status) }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info me-1" title="View Details"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-sm btn-success" title="Download PDF"><i class="fas fa-download"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-light d-flex justify-content-center">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
