@extends('layouts.app')

@section('content')
<div class="form-container">
    <!-- Header Section -->
    <div class="form-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">
                    <i class="fas fa-user-plus"></i>
                    Add New Client
                </h1>
                <p class="page-subtitle">Create a new client record</p>
            </div>
            <a href="{{ route('clients.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Clients</span>
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
        <!-- Client Form -->
        <div class="content-card main-form">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-building"></i>
                    Client Information
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('clients.store') }}" method="POST" class="client-form">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="company_name" class="form-label">
                                Company Name
                                <span class="required">*</span>
                            </label>
                            <input type="text"
                                   class="form-input @error('company_name') error @enderror"
                                   id="company_name"
                                   name="company_name"
                                   value="{{ old('company_name') }}"
                                   placeholder="Enter company name"
                                   required>
                            @error('company_name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact_person" class="form-label">
                                Contact Person
                                <span class="required">*</span>
                            </label>
                            <input type="text"
                                   class="form-input @error('contact_person') error @enderror"
                                   id="contact_person"
                                   name="contact_person"
                                   value="{{ old('contact_person') }}"
                                   placeholder="Enter contact person name"
                                   required>
                            @error('contact_person')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                Email Address
                                <span class="required">*</span>
                            </label>
                            <input type="email"
                                   class="form-input @error('email') error @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="Enter email address"
                                   required>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">
                                Phone Number
                                <span class="required">*</span>
                            </label>
                            <input type="tel"
                                   class="form-input @error('phone') error @enderror"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="Enter phone number"
                                   required>
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="address" class="form-label">
                                Address
                                <span class="required">*</span>
                            </label>
                            <textarea class="form-textarea @error('address') error @enderror"
                                      id="address"
                                      name="address"
                                      rows="3"
                                      placeholder="Enter complete address"
                                      required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="number_of_vehicles" class="form-label">
                                Number of Vehicles
                                <span class="required">*</span>
                            </label>
                            <input type="number"
                                   class="form-input @error('number_of_vehicles') error @enderror"
                                   id="number_of_vehicles"
                                   name="number_of_vehicles"
                                   value="{{ old('number_of_vehicles', 1) }}"
                                   min="1"
                                   placeholder="Enter number of vehicles"
                                   required>
                            @error('number_of_vehicles')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            <span>Create Client</span>
                        </button>
                        <a href="{{ route('clients.index') }}" class="btn-secondary">
                            <i class="fas fa-times"></i>
                            <span>Cancel</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Guidelines Sidebar -->
        <div class="content-card guidelines">
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
                        <span class="guideline-text">Company name should be the official business name</span>
                    </div>
                    <div class="guideline-item">
                        <i class="fas fa-check guideline-icon"></i>
                        <span class="guideline-text">Contact person should be the primary point of contact</span>
                    </div>
                    <div class="guideline-item">
                        <i class="fas fa-check guideline-icon"></i>
                        <span class="guideline-text">Email will be used for system notifications</span>
                    </div>
                    <div class="guideline-item">
                        <i class="fas fa-check guideline-icon"></i>
                        <span class="guideline-text">Phone number should include country code if international</span>
                    </div>
                    <div class="guideline-item">
                        <i class="fas fa-check guideline-icon"></i>
                        <span class="guideline-text">Vehicle count helps in resource planning</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0;
}

.form-header {
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

/* Buttons */
.btn-primary, .btn-secondary {
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

.btn-primary {
    background: #1c2260;
    color: #ffffff;
}

.btn-primary:hover {
    background: #1a1f56;
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

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 24px;
}

.content-card {
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
    display: flex;
    align-items: center;
    gap: 4px;
}

.required {
    color: #ef4444;
    font-size: 12px;
}

.form-input, .form-textarea {
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
    color: #334155;
    background: #ffffff;
    transition: all 0.2s ease;
}

.form-input:focus, .form-textarea:focus {
    outline: none;
    border-color: #1c2260;
    box-shadow: 0 0 0 3px rgba(28, 34, 96, 0.1);
}

.form-input::placeholder, .form-textarea::placeholder {
    color: #94a3b8;
}

.form-input.error, .form-textarea.error {
    border-color: #ef4444;
}

.form-textarea {
    resize: vertical;
    min-height: 80px;
}

.error-message {
    font-size: 12px;
    color: #ef4444;
    margin-top: 4px;
}

.form-actions {
    display: flex;
    gap: 12px;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
}

/* Guidelines */
.guideline-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.guideline-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 16px;
    background: #f8fafc;
    border-radius: 6px;
}

.guideline-icon {
    font-size: 12px;
    color: #10b981;
    margin-top: 2px;
    flex-shrink: 0;
}

.guideline-text {
    font-size: 13px;
    color: #475569;
    line-height: 1.4;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .guidelines {
        order: -1;
    }
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .page-title {
        font-size: 20px;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 16px;
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
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .form-container {
        padding: 0 8px;
    }

    .page-title {
        font-size: 18px;
    }

    .form-input, .form-textarea {
        padding: 10px 12px;
        font-size: 13px;
    }

    .btn-primary, .btn-secondary {
        padding: 10px 16px;
        font-size: 12px;
    }
}
</style>
@endsection
