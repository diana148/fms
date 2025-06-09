@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1 class="page-title">Dashboard</h1>
            <div class="header-meta">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ date('F j, Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-info">
                    <div class="stat-label">Total Clients</div>
                    <div class="stat-value">{{ $totalClients ?? 0 }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-info">
                    <div class="stat-label">Active Contracts</div>
                    <div class="stat-value">{{ $activeContracts ?? 0 }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-file-contract"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-info">
                    <div class="stat-label">Pending Installations</div>
                    <div class="stat-value">{{ $pendingInstallations ?? 0 }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-tools"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-info">
                    <div class="stat-label">Monthly Revenue</div>
                    <div class="stat-value">{{ number_format($monthlyRevenue ?? 0, 0) }}</div>
                    <div class="stat-unit">TZS</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
        <!-- Quick Actions -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt"></i>
                    Quick Actions
                </h3>
            </div>
            <div class="card-body">
                <div class="action-list">
                    <a href="{{ route('clients.create') }}" class="action-item">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add New Client</span>
                        <i class="fas fa-chevron-right action-arrow"></i>
                    </a>
                    <a href="{{ route('contracts.create') }}" class="action-item">
                        <i class="fas fa-file-plus"></i>
                        <span>Create Contract</span>
                        <i class="fas fa-chevron-right action-arrow"></i>
                    </a>
                    <a href="{{ route('installations.create') }}" class="action-item">
                        <i class="fas fa-calendar-plus"></i>
                        <span>Schedule Installation</span>
                        <i class="fas fa-chevron-right action-arrow"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- System Overview -->
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    System Overview
                </h3>
            </div>
            <div class="card-body">
                <div class="overview-list">
                    <div class="overview-item">
                        <div class="overview-info">
                            <i class="fas fa-file-contract overview-icon"></i>
                            <span class="overview-label">Active Contracts</span>
                        </div>
                        <div class="overview-badge success">{{ $activeContracts ?? 0 }}</div>
                    </div>

                    <div class="overview-item">
                        <div class="overview-info">
                            <i class="fas fa-tools overview-icon"></i>
                            <span class="overview-label">Pending Installations</span>
                        </div>
                        <div class="overview-badge warning">{{ $pendingInstallations ?? 0 }}</div>
                    </div>

                    <div class="overview-item">
                        <div class="overview-info">
                            <i class="fas fa-chart-line overview-icon"></i>
                            <span class="overview-label">Monthly Revenue</span>
                        </div>
                        <div class="overview-badge info">{{ number_format($monthlyRevenue ?? 0, 0) }} TZS</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="content-card full-width">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-history"></i>
                Recent Activity
            </h3>
        </div>
        <div class="card-body">
            <div class="empty-state">
                <i class="fas fa-inbox empty-icon"></i>
                <p class="empty-text">No recent activity to display</p>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

.dashboard-header {
    margin-bottom: 24px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 4px;
}

.page-title {
    font-size: 24px;
    font-weight: 600;
    color: #1c2260;
    margin: 0;
}

.header-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #64748b;
    font-size: 13px;
}

.header-meta i {
    font-size: 12px;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.stat-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-info {
    flex: 1;
}

.stat-label {
    font-size: 12px;
    color: #64748b;
    margin-bottom: 4px;
    font-weight: 500;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #1c2260;
    line-height: 1.2;
}

.stat-unit {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 2px;
}

.stat-icon {
    width: 48px;
    height: 48px;
    background: #f1f5f9;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 16px;
}

.stat-icon i {
    font-size: 20px;
    color: #1c2260;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

.content-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.content-card.full-width {
    grid-column: 1 / -1;
}

.card-header {
    padding: 20px 20px 16px;
    border-bottom: 1px solid #f1f5f9;
}

.card-title {
    font-size: 16px;
    font-weight: 600;
    color: #1c2260;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-title i {
    font-size: 14px;
    color: #64748b;
}

.card-body {
    padding: 20px;
}

/* Quick Actions */
.action-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.action-item {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    text-decoration: none;
    color: #334155;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.action-item:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #1c2260;
    text-decoration: none;
}

.action-item i:first-child {
    margin-right: 12px;
    font-size: 14px;
    color: #64748b;
    width: 16px;
}

.action-arrow {
    margin-left: auto;
    font-size: 10px;
    color: #94a3b8;
}

/* System Overview */
.overview-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.overview-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: #f8fafc;
    border-radius: 6px;
}

.overview-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.overview-icon {
    font-size: 14px;
    color: #64748b;
    width: 16px;
}

.overview-label {
    font-size: 13px;
    color: #475569;
    font-weight: 500;
}

.overview-badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}

.overview-badge.success {
    background: #dcfce7;
    color: #166534;
}

.overview-badge.warning {
    background: #fef3c7;
    color: #92400e;
}

.overview-badge.info {
    background: #dbeafe;
    color: #1e40af;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
}

.empty-icon {
    font-size: 48px;
    color: #cbd5e1;
    margin-bottom: 16px;
}

.empty-text {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .page-title {
        font-size: 20px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .content-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .stat-card {
        padding: 16px;
    }

    .card-body {
        padding: 16px;
    }

    .card-header {
        padding: 16px 16px 12px;
    }
}

@media (max-width: 480px) {
    .stat-value {
        font-size: 24px;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        margin-left: 12px;
    }

    .stat-icon i {
        font-size: 18px;
    }
}
</style>
@endsection
