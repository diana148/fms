@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-plus-circle me-3 text-success"></i>Schedule Installation</h1>
        <p class="text-muted mb-0">Fill in the details to schedule a new service installation.</p>
    </div>
    <a href="{{ route('installations.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Installations
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Installation Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('installations.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="contract_id" class="form-label">Contract <span class="text-danger">*</span></label>
                    <select class="form-select @error('contract_id') is-invalid @enderror" id="contract_id" name="contract_id" required>
                        <option value="">Select Contract</option>
                        @foreach($contracts as $contract)
                            <option value="{{ $contract->id }}" {{ old('contract_id') == $contract->id ? 'selected' : '' }}>
                                {{ $contract->contract_number }} ({{ $contract->client->company_name ?? 'No Client' }})
                            </option>
                        @endforeach
                    </select>
                    @error('contract_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="service_type_id" class="form-label">Service Type <span class="text-danger">*</span></label>
                    <select class="form-select @error('service_type_id') is-invalid @enderror" id="service_type_id" name="service_type_id" required>
                        <option value="">Select Service Type</option>
                        @foreach($serviceTypes as $serviceType)
                            <option value="{{ $serviceType->id }}" {{ old('service_type_id') == $serviceType->id ? 'selected' : '' }}>
                                {{ $serviceType->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="vehicle_plate_number" class="form-label">Vehicle Plate Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('vehicle_plate_number') is-invalid @enderror" id="vehicle_plate_number" name="vehicle_plate_number" value="{{ old('vehicle_plate_number') }}" required>
                    @error('vehicle_plate_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="device_serial_number" class="form-label">Device Serial Number</label>
                    <input type="text" class="form-control @error('device_serial_number') is-invalid @enderror" id="device_serial_number" name="device_serial_number" value="{{ old('device_serial_number') }}">
                    @error('device_serial_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="installation_date" class="form-label">Installation Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('installation_date') is-invalid @enderror" id="installation_date" name="installation_date" value="{{ old('installation_date') }}" required>
                    @error('installation_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="technician_id" class="form-label">Assigned Technician <span class="text-danger">*</span></label>
                    <select class="form-select @error('technician_id') is-invalid @enderror" id="technician_id" name="technician_id" required>
                        <option value="">Select Technician</option>
                        @foreach($technicians as $technician)
                            <option value="{{ $technician->id }}" {{ old('technician_id') == $technician->id ? 'selected' : '' }}>
                                {{ $technician->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('technician_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success"><i class="fas fa-calendar-plus me-2"></i>Schedule Installation</button>
            </div>
        </form>
    </div>
</div>
@endsection
