@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-edit me-3 text-warning"></i>Edit Contract: {{ $contract->contract_number }}</h1>
        <p class="text-muted mb-0">Update the details for this client contract.</p>
    </div>
    <a href="{{ route('contracts.show', $contract) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Contract Details
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0"><i class="fas fa-file-contract me-2"></i>Contract Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('contracts.update', $contract) }}" method="POST">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="client_id" class="form-label">Client <span class="text-danger">*</span></label>
                    <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                        <option value="">Select Client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ (old('client_id', $contract->client_id) == $client->id) ? 'selected' : '' }}>
                                {{ $client->company_name }} ({{ $client->contact_person }})
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="currency" class="form-label">Currency <span class="text-danger">*</span></label>
                    <select class="form-select @error('currency') is-invalid @enderror" id="currency" name="currency" required>
                        <option value="TZS" {{ (old('currency', $contract->currency) == 'TZS') ? 'selected' : '' }}>TZS (Tanzanian Shilling)</option>
                        <option value="USD" {{ (old('currency', $contract->currency) == 'USD') ? 'selected' : '' }}>USD (US Dollar)</option>
                    </select>
                    @error('currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $contract->start_date->format('Y-m-d')) }}" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $contract->end_date->format('Y-m-d')) }}" required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Services for this Contract</h5>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-service-btn"><i class="fas fa-plus me-1"></i>Add Service</button>
            </div>

            <div id="service-container">
                {{-- Loop through existing services or old input if validation fails --}}
                @php
                    $currentServices = old('services', $contract->contractServices->toArray());
                @endphp

                @foreach($currentServices as $index => $service)
                    <div class="row service-item mb-3 p-3 border rounded bg-light position-relative">
                        <div class="col-md-5 mb-3">
                            <label for="service_type_id_{{ $index }}" class="form-label">Service Type <span class="text-danger">*</span></label>
                            <select class="form-select service-type-select @error('services.' . $index . '.service_type_id') is-invalid @enderror" id="service_type_id_{{ $index }}" name="services[{{ $index }}][service_type_id]" required>
                                <option value="">Select Service Type</option>
                                @foreach($serviceTypes as $serviceType)
                                    <option value="{{ $serviceType->id }}"
                                            data-installation-tzs="{{ $serviceType->installation_price_tzs }}"
                                            data-monthly-tzs="{{ $serviceType->monthly_price_tzs }}"
                                            data-installation-usd="{{ $serviceType->installation_price_usd }}"
                                            data-monthly-usd="{{ $serviceType->monthly_price_usd }}"
                                            {{ ($service['service_type_id'] == $serviceType->id) ? 'selected' : '' }}>
                                        {{ $serviceType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('services.' . $index . '.service_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="quantity_{{ $index }}" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control service-quantity @error('services.' . $index . '.quantity') is-invalid @enderror" id="quantity_{{ $index }}" name="services[{{ $index }}][quantity]" value="{{ $service['quantity'] }}" min="1" required>
                            @error('services.' . $index . '.quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Inst. Cost</label>
                            <p class="form-control-plaintext service-installation-cost" data-index="{{ $index }}"></p>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Monthly Cost</label>
                            <p class="form-control-plaintext service-monthly-cost" data-index="{{ $index }}"></p>
                        </div>
                        <button type="button" class="btn-close remove-service-btn position-absolute top-0 end-0 m-2" aria-label="Remove Service"></button>
                    </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <div class="col-md-6 offset-md-6">
                    <div class="card bg-light p-3">
                        <h6 class="mb-2">Summary:</h6>
                        <div class="d-flex justify-content-between">
                            <strong>Total Installation Cost:</strong>
                            <span id="total-installation-cost">0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <strong>Total Monthly Cost:</strong>
                            <span id="total-monthly-cost">0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-warning"><i class="fas fa-save me-2"></i>Update Contract</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let serviceIndex = {{ count(old('services', $contract->contractServices->toArray())) }};
    const serviceTypes = @json($serviceTypes->keyBy('id'));

    function addServiceRow() {
        const container = document.getElementById('service-container');
        const row = document.createElement('div');
        row.classList.add('row', 'service-item', 'mb-3', 'p-3', 'border', 'rounded', 'bg-light', 'position-relative');
        row.innerHTML = `
            <div class="col-md-5 mb-3">
                <label for="service_type_id_${serviceIndex}" class="form-label">Service Type <span class="text-danger">*</span></label>
                <select class="form-select service-type-select" id="service_type_id_${serviceIndex}" name="services[${serviceIndex}][service_type_id]" required>
                    <option value="">Select Service Type</option>
                    @foreach($serviceTypes as $serviceType)
                        <option value="{{ $serviceType->id }}"
                                data-installation-tzs="{{ $serviceType->installation_price_tzs }}"
                                data-monthly-tzs="{{ $serviceType->monthly_price_tzs }}"
                                data-installation-usd="{{ $serviceType->installation_price_usd }}"
                                data-monthly-usd="{{ $serviceType->monthly_price_usd }}">
                            {{ $serviceType->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="quantity_${serviceIndex}" class="form-label">Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control service-quantity" id="quantity_${serviceIndex}" name="services[${serviceIndex}][quantity]" value="1" min="1" required>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Inst. Cost</label>
                <p class="form-control-plaintext service-installation-cost" data-index="${serviceIndex}"></p>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Monthly Cost</label>
                <p class="form-control-plaintext service-monthly-cost" data-index="${serviceIndex}"></p>
            </div>
            <button type="button" class="btn-close remove-service-btn position-absolute top-0 end-0 m-2" aria-label="Remove Service"></button>
        `;
        container.appendChild(row);

        // Add event listeners to the new row elements
        row.querySelector('.service-type-select').addEventListener('change', updateCosts);
        row.querySelector('.service-quantity').addEventListener('input', updateCosts);
        row.querySelector('.remove-service-btn').addEventListener('click', removeServiceRow);

        updateCosts(); // Update totals after adding a new row
        serviceIndex++;
    }

    function removeServiceRow(event) {
        event.target.closest('.service-item').remove();
        updateCosts(); // Update totals after removing a row
    }

    function updateCosts() {
        let totalInstallation = 0;
        let totalMonthly = 0;
        const currency = document.getElementById('currency').value.toLowerCase(); // 'tzs' or 'usd'

        document.querySelectorAll('.service-item').forEach(item => {
            const serviceTypeSelect = item.querySelector('.service-type-select');
            const quantityInput = item.querySelector('.service-quantity');
            const installationCostDisplay = item.querySelector('.service-installation-cost');
            const monthlyCostDisplay = item.querySelector('.service-monthly-cost');

            const selectedServiceTypeId = serviceTypeSelect.value;
            const quantity = parseInt(quantityInput.value) || 0;

            if (selectedServiceTypeId && serviceTypes[selectedServiceTypeId]) {
                const service = serviceTypes[selectedServiceTypeId];
                const installationPrice = parseFloat(service[`installation_price_${currency}`]) || 0;
                const monthlyPrice = parseFloat(service[`monthly_price_${currency}`]) || 0;

                const currentInstallationCost = installationPrice * quantity;
                const currentMonthlyCost = monthlyPrice * quantity;

                totalInstallation += currentInstallationCost;
                totalMonthly += currentMonthlyCost;

                installationCostDisplay.textContent = `${currency.toUpperCase()} ${currentInstallationCost.toFixed(2)}`;
                monthlyCostDisplay.textContent = `${currency.toUpperCase()} ${currentMonthlyCost.toFixed(2)}`;
            } else {
                installationCostDisplay.textContent = `${currency.toUpperCase()} 0.00`;
                monthlyCostDisplay.textContent = `${currency.toUpperCase()} 0.00`;
            }
        });

        document.getElementById('total-installation-cost').textContent = `${currency.toUpperCase()} ${totalInstallation.toFixed(2)}`;
        document.getElementById('total-monthly-cost').textContent = `${currency.toUpperCase()} ${totalMonthly.toFixed(2)}`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add-service-btn').addEventListener('click', addServiceRow);
        document.getElementById('currency').addEventListener('change', updateCosts);

        // Initial setup for existing services (pre-filled from $contract->contractServices)
        // and for old input if validation fails
        document.querySelectorAll('.service-type-select').forEach(select => {
            select.addEventListener('change', updateCosts);
        });
        document.querySelectorAll('.service-quantity').forEach(input => {
            input.addEventListener('input', updateCosts);
        });
        document.querySelectorAll('.remove-service-btn').forEach(btn => {
            btn.addEventListener('click', removeServiceRow);
        });

        // Ensure costs are calculated on page load for existing inputs
        updateCosts();
    });
</script>
@endpush
