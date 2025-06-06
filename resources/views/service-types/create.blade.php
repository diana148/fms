@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-plus-circle me-3 text-success"></i>Create Service Type</h1>
        <p class="text-muted mb-0">Fill in the details to add a new service type.</p>
    </div>
    <a href="{{ route('service-types.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Service Types
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Service Type Information</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('service-types.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Service Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="installation_price_tzs" class="form-label">Installation Price (TZS) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('installation_price_tzs') is-invalid @enderror" id="installation_price_tzs" name="installation_price_tzs" value="{{ old('installation_price_tzs', 0) }}" required min="0">
                    @error('installation_price_tzs')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="monthly_price_tzs" class="form-label">Monthly Price (TZS) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('monthly_price_tzs') is-invalid @enderror" id="monthly_price_tzs" name="monthly_price_tzs" value="{{ old('monthly_price_tzs', 0) }}" required min="0">
                    @error('monthly_price_tzs')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="installation_price_usd" class="form-label">Installation Price (USD) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('installation_price_usd') is-invalid @enderror" id="installation_price_usd" name="installation_price_usd" value="{{ old('installation_price_usd', 0) }}" required min="0">
                    @error('installation_price_usd')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="monthly_price_usd" class="form-label">Monthly Price (USD) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('monthly_price_usd') is-invalid @enderror" id="monthly_price_usd" name="monthly_price_usd" value="{{ old('monthly_price_usd', 0) }}" required min="0">
                    @error('monthly_price_usd')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Is Active?</label>
                @error('is_active')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success"><i class="fas fa-plus-circle me-2"></i>Add Service Type</button>
            </div>
        </form>
    </div>
</div>
@endsection
