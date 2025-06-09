@extends('layouts.app')

@section('content')
<div class="edit-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="fas fa-user-edit"></i>
                    Edit Client
                </h1>
                <p class="page-subtitle">Update client information for {{ $client->company_name }}</p>
            </div>
            <a href="{{ route('clients.show', $client) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Client</span>
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
        <!-- Main Form -->
        <div class="form-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-building"></i>
                    Client Information
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('clients.update', $client) }}" method="POST" class="client-form">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="company_name" class="form-label">
                                Company Name <span class="required">*</span>
                            </label>
                            <input type="text"
                                   class="form-input @error('company_name') error @enderror"
                                   id="company_name"
                                   name="company_name"
                                   value="{{ old('company_name', $client->company_name) }}"
                                   required>
                            @error('company_name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact_person" class="form-label">
                                Contact Person <span class="required">*</span>
                            </label>
                            <input type="text"
                                   class="form-input @error('contact_person') error @enderror"
                                   id="contact_person"
                                   name="contact_person"
                                   value="{{ old('contact_person', $client->contact_person) }}"
                                   required>
                            @error('contact_person')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                Email Address <span class="required">*</span>
                            </label>
                            <input type="email"
                                   class="form-input @error('email') error @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $client->email) }}"
                                   required>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">
                                Phone Number <span class="required">*</span>
                            </label>
                            <input type="tel"
                                   class="form-input @error('phone') error @enderror"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone', $client->phone) }}"
                                   required>
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="address" class="form-label">
                                Address <span class="required">*</span>
                            </label>
                            <textarea class="form-input textarea @error('address') error @enderror"
                                      id="address"
                                      name="address"
                                      rows="3"
                                      required>{{ old('address', $client->address) }}</textarea>
                            @error('address')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="number_of_vehicles" class="form-label">
                                Number of Vehicles <span class="required">*</span>
                            </label>
                            <input type="number"
                                   class="form-input @error('number_of_vehicles') error @enderror"
                                   id="number_of_vehicles"
                                   name="number_of_vehicles"
                                   value="{{ old('number_of_vehicles', $client->number_of_vehicles) }}"
                                   min="1"
                                   required>
                            @error('number_of_vehicles')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            <span>Update Client</span>
                        </button>
                        <a href="{{ route('clients.show', $client) }}" class="btn-secondary">
                            <i class="fas fa-times"></i>
                            <span>Cancel</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Last Updated Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock"></i>
                        Last Updated
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Created:</span>
                            <span class="info-value">{{ $client->created_at->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Updated:</span>
                            <span class="info-value">{{ $client->updated_at->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guidelines Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Guidelines
                    </h3>
                </div>
                <div class="card-body">
                    <div class="guideline-list">
                        <div class="guideline-item">
                            <i class="fas fa-check guideline-icon"></i>
                            <span>Ensure all contact information is current</span>
                        </div>
                        <div class="guideline-item">
                            <i class="fas fa-check guideline-icon"></i>
                            <span>Vehicle count affects service planning</span>
                        </div>
                        <div class="guideline-item">
                            <i class="fas fa-check guideline-icon"></i>
                            <span>Changes will be reflected in all related contracts</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.edit-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

/* Header Section */
.page-header {
    margin-bottom: 24px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 0 4px;
}

.title-section {
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

.back-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    text-decoration: none;
    color: #475569;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.back-btn:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: #1c2260;
    text-decoration: none;
}

.back-btn i {
    font-size: 12px;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 24px;
}

/* Form Card */
.form-card, .info-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
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

/* Form Styles */
.client-form {
    width: 100%;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 24px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 6px;
}

.required {
    color: #dc2626;
}

.form-input {
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    color: #374151;
    background: #ffffff;
    transition: all 0.2s ease;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input.error {
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.form-input.textarea {
    resize: vertical;
    min-height: 80px;
}

.error-message {
    font-size: 12px;
    color: #dc2626;
    margin-top: 4px;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 12px;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
}

.btn-primary, .btn-secondary {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary {
    background: #3b82f6;
    color: #ffffff;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-secondary {
    background: #6b7280;
    color: #ffffff;
}

.btn-secondary:hover {
    background: #4b5563;
    text-decoration: none;
}

.btn-primary i, .btn-secondary i {
    font-size: 12px;
}

/* Sidebar */
.sidebar {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* Info Lists */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 8px 0;
}

.info-label {
    font-size: 12px;
    color: #64748b;
    font-weight: 500;
    min-width: 60px;
}

.info-value {
    font-size: 12px;
    color: #374151;
    text-align: right;
    flex: 1;
}

/* Guidelines */
.guideline-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.guideline-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 12px;
    color: #475569;
    line-height: 1.4;
}

.guideline-icon {
    font-size: 10px;
    color: #22c55e;
    margin-top: 2px;
    flex-shrink: 0;
}

/* Responsive Design */
@media (max-width: 968px) {
    .content-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .sidebar {
        order: -1;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .page-title {
        font-size: 20px;
    }

    .card-body {
        padding: 16px;
    }

    .card-header {
        padding: 16px 16px 12px;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-primary, .btn-secondary {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .back-btn span {
        display: none;
    }

    .page-title i {
        font-size: 18px;
    }

    .form-grid {
        gap: 12px;
    }
}
</style>
@endsection
