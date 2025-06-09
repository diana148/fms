@extends('layouts.app')

@section('content')
<div class="clients-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">Clients Management</h1>
            </div>
            <a href="{{ route('clients.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i>
                <span>Add New Client</span>
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="search-section">
        <div class="search-container">
            <div class="search-input-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search clients..." id="searchInput">
            </div>
            <div class="search-stats">
                <span class="results-count">{{ $clients->total() }} clients found</span>
            </div>
        </div>
    </div>

    <!-- Clients Grid -->
    <div class="clients-grid">
        @if($clients->count() > 0)
            @foreach($clients as $client)
                <div class="client-card">
                    <div class="client-header">
                        <div class="client-avatar">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="client-info">
                            <h3 class="client-name">{{ $client->company_name }}</h3>
                            <p class="client-id">ID: #{{ $client->id }}</p>
                        </div>
                        <div class="client-actions">
                            <div class="action-dropdown">
                                <button class="action-btn" onclick="toggleDropdown({{ $client->id }})">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" id="dropdown-{{ $client->id }}">
                                    <a href="{{ route('clients.show', $client) }}" class="dropdown-item">
                                        <i class="fas fa-eye"></i>
                                        <span>View Details</span>
                                    </a>
                                    <a href="{{ route('clients.edit', $client) }}" class="dropdown-item">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit Client</span>
                                    </a>
                                    <button class="dropdown-item delete-item" onclick="confirmDelete({{ $client->id }}, '{{ $client->company_name }}')">
                                        <i class="fas fa-trash"></i>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="client-details">
                        <div class="detail-row">
                            <i class="fas fa-user detail-icon"></i>
                            <span class="detail-label">Contact:</span>
                            <span class="detail-value">{{ $client->contact_person }}</span>
                        </div>
                        <div class="detail-row">
                            <i class="fas fa-envelope detail-icon"></i>
                            <span class="detail-label">Email:</span>
                            <a href="mailto:{{ $client->email }}" class="detail-value link">{{ $client->email }}</a>
                        </div>
                        <div class="detail-row">
                            <i class="fas fa-phone detail-icon"></i>
                            <span class="detail-label">Phone:</span>
                            <a href="tel:{{ $client->phone }}" class="detail-value link">{{ $client->phone }}</a>
                        </div>
                        <div class="detail-row">
                            <i class="fas fa-map-marker-alt detail-icon"></i>
                            <span class="detail-label">Location:</span>
                            <span class="detail-value">{{ Str::limit($client->address, 40) }}</span>
                        </div>
                    </div>

                    <div class="client-stats">
                        <div class="stat-item">
                            <div class="stat-value">{{ $client->number_of_vehicles }}</div>
                            <div class="stat-label">Vehicles</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $client->contracts_count ?? 0 }}</div>
                            <div class="stat-label">Contracts</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $client->created_at->diffForHumans() }}</div>
                            <div class="stat-label">Added</div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="empty-title">No Clients Found</h3>
                <p class="empty-text">Start by adding your first client to the system.</p>
                <a href="{{ route('clients.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>Add First Client</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($clients->hasPages())
        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $clients->firstItem() }} to {{ $clients->lastItem() }} of {{ $clients->total() }} results
            </div>
            <div class="pagination-controls">
                {{ $clients->links() }}
            </div>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Confirm Delete</h3>
            <button type="button" class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <p>Are you sure you want to delete client <strong id="clientName"></strong>?</p>
            <p class="modal-warning">This action cannot be undone and will affect all related contracts.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Delete Client</button>
            </form>
        </div>
    </div>
</div>

<style>
.clients-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

.page-header {
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
}

.page-subtitle {
    color: #64748b;
    font-size: 14px;
}

.btn-primary {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #1c2260;
    color: white;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-primary:hover {
    background: #151a4a;
    color: white;
    text-decoration: none;
}

.btn-secondary {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f1f5f9;
    color: #64748b;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-secondary:hover {
    background: #e2e8f0;
    color: #475569;
}

.btn-danger {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #dc2626;
    color: white;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-danger:hover {
    background: #b91c1c;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
    padding: 16px 20px;
    border-radius: 8px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid #bbf7d0;
}

.alert-close {
    background: none;
    border: none;
    color: #166534;
    margin-left: auto;
    cursor: pointer;
    padding: 4px;
}

.search-section {
    margin-bottom: 24px;
}

.search-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
}

.search-input-wrapper {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
}

.search-input {
    width: 100%;
    padding: 12px 16px 12px 48px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    background: white;
    transition: border-color 0.2s ease;
}

.search-input:focus {
    outline: none;
    border-color: #1c2260;
}

.results-count {
    color: #64748b;
    font-size: 14px;
    font-weight: 500;
}

.clients-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.client-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    transition: all 0.2s ease;
}

.client-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    border-color: #cbd5e1;
}

.client-header {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 16px;
}

.client-avatar {
    width: 48px;
    height: 48px;
    background: #f1f5f9;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.client-avatar i {
    font-size: 20px;
    color: #1c2260;
}

.client-info {
    flex: 1;
}

.client-name {
    font-size: 16px;
    font-weight: 600;
    color: #1c2260;
    margin: 0 0 4px 0;
}

.client-id {
    color: #64748b;
    font-size: 12px;
    margin: 0;
}

.client-actions {
    position: relative;
}

.action-btn {
    width: 32px;
    height: 32px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.action-btn:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

.action-btn i {
    color: #64748b;
    font-size: 12px;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 10;
    min-width: 160px;
    display: none;
    margin-top: 4px;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    color: #334155;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.dropdown-item:hover {
    background: #f8fafc;
    color: #1c2260;
    text-decoration: none;
}

.dropdown-item.delete-item:hover {
    background: #fef2f2;
    color: #dc2626;
}

.client-details {
    margin-bottom: 16px;
}

.detail-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    font-size: 13px;
}

.detail-row:last-child {
    margin-bottom: 0;
}

.detail-icon {
    width: 14px;
    color: #94a3b8;
    font-size: 12px;
}

.detail-label {
    color: #64748b;
    font-weight: 500;
    min-width: 60px;
}

.detail-value {
    color: #334155;
    flex: 1;
}

.detail-value.link {
    color: #1c2260;
    text-decoration: none;
}

.detail-value.link:hover {
    text-decoration: underline;
}

.client-stats {
    display: flex;
    justify-content: space-between;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
}

.stat-item {
    text-align: center;
    flex: 1;
}

.stat-value {
    font-size: 16px;
    font-weight: 600;
    color: #1c2260;
    margin-bottom: 2px;
}

.stat-label {
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: #f8fafc;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-icon i {
    font-size: 32px;
    color: #cbd5e1;
}

.empty-title {
    font-size: 20px;
    font-weight: 600;
    color: #1c2260;
    margin-bottom: 8px;
}

.empty-text {
    color: #64748b;
    margin-bottom: 24px;
}

.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0;
    border-top: 1px solid #f1f5f9;
}

.pagination-info {
    color: #64748b;
    font-size: 14px;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-overlay.show {
    display: flex;
}

.modal-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 90%;
    max-height: 90vh;
    overflow: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
}

.modal-title {
    font-size: 18px;
    font-weight: 600;
    color: #1c2260;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    color: #64748b;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: background-color 0.2s ease;
}

.modal-close:hover {
    background: #f1f5f9;
}

.modal-body {
    padding: 24px;
    text-align: center;
}

.modal-icon {
    width: 64px;
    height: 64px;
    background: #fef3c7;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}

.modal-icon i {
    font-size: 24px;
    color: #f59e0b;
}

.modal-body p {
    color: #334155;
    margin-bottom: 8px;
}

.modal-warning {
    color: #64748b;
    font-size: 14px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 20px 24px;
    border-top: 1px solid #f1f5f9;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
    }

    .search-container {
        flex-direction: column;
        align-items: stretch;
    }

    .search-input-wrapper {
        max-width: none;
    }

    .clients-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .pagination-container {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }

    .modal-container {
        margin: 20px;
    }
}

@media (max-width: 480px) {
    .client-card {
        padding: 16px;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 16px 20px;
    }
}
</style>

<script>
function toggleDropdown(clientId) {
    const dropdown = document.getElementById('dropdown-' + clientId);
    const allDropdowns = document.querySelectorAll('.dropdown-menu');

    // Close all other dropdowns
    allDropdowns.forEach(menu => {
        if (menu !== dropdown) {
            menu.classList.remove('show');
        }
    });

    dropdown.classList.toggle('show');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.client-actions')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
    }
});

function confirmDelete(clientId, clientName) {
    document.getElementById('clientName').textContent = clientName;
    document.getElementById('deleteForm').action = '/clients/' + clientId;
    document.getElementById('deleteModal').classList.add('show');
}

function closeModal() {
    document.getElementById('deleteModal').classList.remove('show');
}

// Close modal when clicking overlay
document.getElementById('deleteModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeModal();
    }
});

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const clientCards = document.querySelectorAll('.client-card');

    clientCards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(searchTerm) ? 'block' : 'none';
    });
});
</script>
@endsection
