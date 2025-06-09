@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-cog me-3 text-secondary"></i>Application Settings</h1>
        <p class="text-muted mb-0">Configure general application preferences, user management, and email settings.</p>
    </div>
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
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-tools me-2"></i>General Settings</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="default_currency" class="form-label">Default Currency</label>
                <select class="form-select" id="default_currency" name="default_currency">
                    <option value="TZS" {{ old('default_currency', $defaultCurrency) == 'TZS' ? 'selected' : '' }}>TZS (Tanzanian Shilling)</option>
                    <option value="USD" {{ old('default_currency', $defaultCurrency) == 'USD' ? 'selected' : '' }}>USD (United States Dollar)</option>
                </select>
                @error('default_currency')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Save General Settings</button>
        </form>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-envelope-open-text me-2"></i>Email (SMTP) Settings</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="smtp_host" class="form-label">SMTP Host</label>
                    <input type="text" class="form-control" id="smtp_host" name="smtp_host" value="{{ old('smtp_host', $smtpHost) }}">
                    @error('smtp_host')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="smtp_port" class="form-label">SMTP Port</label>
                    <input type="number" class="form-control" id="smtp_port" name="smtp_port" value="{{ old('smtp_port', $smtpPort) }}">
                    @error('smtp_port')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="smtp_username" class="form-label">SMTP Username</label>
                    <input type="text" class="form-control" id="smtp_username" name="smtp_username" value="{{ old('smtp_username', $smtpUsername) }}">
                    @error('smtp_username')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="smtp_password" class="form-label">SMTP Password</label>
                    <input type="password" class="form-control" id="smtp_password" name="smtp_password" value="{{ old('smtp_password', $smtpPassword) }}" autocomplete="off">
                    <small class="form-text text-muted">Leave blank to keep current password.</small>
                    @error('smtp_password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="smtp_encryption" class="form-label">Encryption</label>
                    <select class="form-select" id="smtp_encryption" name="smtp_encryption">
                        <option value="">None</option>
                        <option value="tls" {{ old('smtp_encryption', $smtpEncryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                        <option value="ssl" {{ old('smtp_encryption', $smtpEncryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                    </select>
                    @error('smtp_encryption')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="smtp_from_address" class="form-label">From Email Address</label>
                    <input type="email" class="form-control" id="smtp_from_address" name="smtp_from_address" value="{{ old('smtp_from_address', $smtpFromAddress) }}">
                    @error('smtp_from_address')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="smtp_from_name" class="form-label">From Name</label>
                <input type="text" class="form-control" id="smtp_from_name" name="smtp_from_name" value="{{ old('smtp_from_name', $smtpFromName) }}">
                @error('smtp_from_name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Save Email Settings</button>
        </form>
    </div>
</div>
@endsection
