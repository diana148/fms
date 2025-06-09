@extends('layouts.app')

@section('content')
<div class="details-container">
    <!-- Header Section -->
    <div class="details-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">
                    <i class="fas fa-building"></i>
                    {{ $client->company_name }}
                </h1>
                <p class="page-subtitle">Client Details & Contract Information</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('clients.edit', $client) }}" class="btn-warning">
                    <i class="fas fa-edit"></i>
                    <span>Edit Client</span>
                </a>
                <a href="{{ route('clients.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Clients</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
        <!-- Client Information -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Client Information
                </h3>
            </div>
            <div class="section-body">
                <div class="info-list">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-building"></i>
                            Company Name
                        </div>
                        <div class="info-value">{{ $client->company_name }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-user"></i>
                            Contact Person
                        </div>
                        <div class="info-value">{{ $client->contact_person }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </div>
                        <div class="info-value">
                            <a href="mailto:{{ $client->email }}" class="info-link">
                                {{ $client->email }}
                            </a>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>
                            Phone Number
                        </div>
                        <div class="info-value">
                            <a href="tel:{{ $client->phone }}" class="info-link">
                                {{ $client->phone }}
                            </a>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Address
                        </div>
                        <div class="info-value">{{ $client->address }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-car"></i>
                            Number of Vehicles
                        </div>
                        <div class="info-value">
                            <span class="info-badge">{{ $client->number_of_vehicles }} vehicles</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-file-contract"></i>
                            Total Contracts
                        </div>
                        <div class="info-value">
                            <span class="info-badge">{{ $client->contracts->count() }} contracts</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-check-circle"></i>
                            Active Contracts
                        </div>
                        <div class="info-value">
                            <span class="info-badge active">{{ $client->contracts->where('end_date', '>', now())->count() }} active</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-plus"></i>
                            Created Date
                        </div>
                        <div class="info-value">{{ $client->created_at->format('M d, Y') }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-edit"></i>
                            Last Updated
                        </div>
                        <div class="info-value">{{ $client->updated_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contracts Section -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-file-contract"></i>
                    Contracts ({{ $client->contracts->count() }})
                </h3>
                @if($client->contracts->count() > 0)
                    <a href="{{ route('contracts.create', ['client_id' => $client->id]) }}" class="btn-primary-sm">
                        <i class="fas fa-plus"></i>
                        <span>New Contract</span>
                    </a>
                @endif
            </div>
            <div class="section-body">
                @if($client->contracts->count() > 0)
                    <div class="contracts-list">
                        @foreach($client->contracts as $contract)
                        <div class="contract-card">
                            <div class="contract-header">
                                <div class="contract-info">
                                    <h4 class="contract-title">Contract #{{ $contract->id }}</h4>
                                    <div class="contract-meta">
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
                                        <span class="status-badge {{ $statusClass }}">{{ ucfirst($status) }}</span>
                                    </div>
                                </div>
                                <div class="contract-actions">
                                    <a href="{{ route('contracts.show', $contract) }}" class="action-btn view" title="View Contract">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('contracts.edit', $contract) }}" class="action-btn edit" title="Edit Contract">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="contract-details">
                                <div class="detail-row">
                                    <div class="detail-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        Start Date
                                    </div>
                                    <div class="detail-value">{{ $contract->start_date ? $contract->start_date->format('M d, Y') : 'N/A' }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">
                                        <i class="fas fa-calendar-times"></i>
                                        End Date
                                    </div>
                                    <div class="detail-value">{{ $contract->end_date ? $contract->end_date->format('M d, Y') : 'N/A' }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">
                                        <i class="fas fa-cogs"></i>
                                        Services
                                    </div>
                                    <div class="detail-value">
                                        @if($contract->contractServices->count() > 0)
                                            <div class="services-list">
                                                @foreach($contract->contractServices as $service)
                                                    <span class="service-badge">{{ $service->serviceType->name ?? 'N/A' }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="no-services">No services assigned</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-file-contract empty-icon"></i>
                        <h4 class="empty-title">No Contracts Found</h4>
                        <p class="empty-text">This client doesn't have any contracts yet.</p>
                        <a href="{{ route('contracts.create', ['client_id' => $client->id]) }}" class="btn-primary">
                            <i class="fas fa-plus"></i>
                            <span>Create First Contract</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.details-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0;
}

.details-header {
    margin-bottom: 24px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 4px;
}

.header-info {
    flex: 1;
}

.page-title {
    font-size: 24px;
    font-weight: 600;
    color: #1c2260;
    margin: 0 0 4px 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-title i {
    font-size: 20px;
    color: #64748b;
}

.page-subtitle {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 12px;
}

/* Buttons */
.btn-primary, .btn-primary-sm, .btn-warning, .btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary-sm {
    padding: 8px 16px;
    font-size: 12px;
}

.btn-primary, .btn-primary-sm {
    background: #1c2260;
    color: #ffffff;
}

.btn-primary:hover, .btn-primary-sm:hover {
    background: #1a1f56;
    color: #ffffff;
    text-decoration: none;
}

.btn-warning {
    background: #f59e0b;
    color: #ffffff;
}

.btn-warning:hover {
    background: #d97706;
    color: #ffffff;
    text-decoration: none;
}

.btn-secondary {
    background: #ffffff;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background: #f8fafc;
    color: #1c2260;
    border-color: #cbd5e1;
    text-decoration: none;
}

/* Content Wrapper */
.content-wrapper {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* Section Cards */
.section-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.section-header {
    padding: 20px 20px 16px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-title {
    font-size: 16px;
    font-weight: 600;
    color: #1c2260;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-title i {
    font-size: 14px;
    color: #64748b;
}

.section-body {
    padding: 20px;
}

/* Info List */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 0;
    border-bottom: 1px solid #f1f5f9;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 14px;
    font-weight: 500;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
}

.info-label i {
    font-size: 12px;
    color: #94a3b8;
    width: 16px;
}

.info-value {
    font-size: 14px;
    color: #334155;
    font-weight: 500;
    text-align: right;
}

.info-link {
    color: #1c2260;
    text-decoration: none;
}

.info-link:hover {
    color: #1a1f56;
    text-decoration: underline;
}

.info-badge {
    background: #f1f5f9;
    color: #64748b;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.info-badge.active {
    background: #dcfce7;
    color: #166534;
}

/* Contracts List */
.contracts-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.contract-card {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 16px;
    transition: all 0.2s ease;
}

.contract-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.contract-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.contract-info {
    flex: 1;
}

.contract-title {
    font-size: 16px;
    font-weight: 600;
    color: #1c2260;
    margin: 0 0 4px 0;
}

.contract-meta {
    display: flex;
    align-items: center;
    gap: 8px;
}

.contract-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s ease;
}

.action-btn.view {
    background: #dbeafe;
    color: #1e40af;
}

.action-btn.view:hover {
    background: #bfdbfe;
    color: #1d4ed8;
    text-decoration: none;
}

.action-btn.edit {
    background: #fef3c7;
    color: #92400e;
}

.action-btn.edit:hover {
    background: #fde68a;
    color: #78350f;
    text-decoration: none;
}

.contract-details {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-label {
    font-size: 13px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
}

.detail-label i {
    font-size: 11px;
    color: #94a3b8;
    width: 14px;
}

.detail-value {
    font-size: 13px;
    color: #334155;
    font-weight: 500;
}

.services-list {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    justify-content: flex-end;
}

.service-badge {
    background: #f1f5f9;
    color: #64748b;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 500;
}

.no-services {
    color: #94a3b8;
    font-style: italic;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.success {
    background: #dcfce7;
    color: #166534;
}

.status-badge.warning {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.danger {
    background: #fee2e2;
    color: #dc2626;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    font-size: 64px;
    color: #cbd5e1;
    margin-bottom: 20px;
}

.empty-title {
    font-size: 18px;
    font-weight: 600;
    color: #64748b;
    margin: 0 0 8px 0;
}

.empty-text {
    font-size: 14px;
    color: #94a3b8;
    margin: 0 0 24px 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .header-actions {
        width: 100%;
        flex-direction: column;
    }

    .btn-primary, .btn-warning, .btn-secondary {
        width: 100%;
        justify-content: center;
    }

    .page-title {
        font-size: 20px;
    }

    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        padding: 12px 0;
    }

    .info-value {
        text-align: left;
        width: 100%;
    }

    .contract-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .contract-actions {
        width: 100%;
        justify-content: flex-end;
    }

    .detail-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }

    .detail-value {
        width: 100%;
    }

    .services-list {
        justify-content: flex-start;
    }

    .section-body {
        padding: 16px;
    }

    .section-header {
        padding: 16px 16px 12px;
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}

@media (max-width: 480px) {
    .empty-state {
        padding: 40px 16px;
    }

    .empty-icon {
        font-size: 48px;
    }

    .contract-card {
        padding: 12px;
    }

    .info-row {
        padding: 10px 0;
    }
}
</style>
@endsection
