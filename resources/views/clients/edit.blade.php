@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-user-edit me-3 text-primary"></i>Edit Client</h1>
        <p class="text-muted mb-0">Update client information for {{ $client->company_name }}</p>
    </div>
    <a href="{{ route('clients.show', $client) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Client
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Client Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('clients.update', $client) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                   id="company_name" name="company_name" value="{{ old('company_name', $client->company_name) }}" required>
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contact_person" class="form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                   id="contact_person" name="contact_person" value="{{ old('contact_person', $client->contact_person) }}" required>
                            @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $client->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', $client->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror"
                                  id="address" name="address" rows="3" required>{{ old('address', $client->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="number_of_vehicles" class="form-label">Number of Vehicles <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('number_of_vehicles') is-invalid @enderror"
                               id="number_of_vehicles" name="number_of_vehicles" value="{{ old('number_of_vehicles', $client->number_of_vehicles) }}"
                               min="1" required>
                        @error('number_of_vehicles')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Client
                        </button>
                        <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Last Updated</h6>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Created:</strong> {{ $client->created_at->format('M d, Y \a\t g:i A') }}</p>
                <p class="mb-0"><strong>Updated:</strong> {{ $client->updated_at->format('M d, Y \a\t g:i A') }}</p>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Guidelines</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 small">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Ensure all contact information is current</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Vehicle count affects service planning</li>
                    <li class="mb-0"><i class="fas fa-check text-success me-2"></i>Changes will be reflected in all related contracts</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
