<?php

namespace App\Http\Controllers;

use App\Models\Contract; // Add this line
use App\Models\Client; // Add this line
use App\Models\ServiceType; // Add this line
use App\Models\ContractService; // Add this line
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('client')->paginate(15);
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $clients = Client::where('status', 'active')->get();
        $serviceTypes = ServiceType::where('is_active', true)->get();
        return view('contracts.create', compact('clients', 'serviceTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'currency' => 'required|in:TZS,USD',
            'services' => 'required|array',
            'services.*.service_type_id' => 'required|exists:service_types,id',
            'services.*.quantity' => 'required|integer|min:1',
        ]);

        $contract = new Contract();
        $contract->contract_number = 'CNT-' . date('Y') . '-' . str_pad(Contract::count() + 1, 4, '0', STR_PAD_LEFT);
        $contract->client_id = $validated['client_id'];
        $contract->start_date = $validated['start_date'];
        $contract->end_date = $validated['end_date'];
        $contract->currency = $validated['currency'];

        $totalInstallationCost = 0;
        $totalMonthlyCost = 0;

        foreach ($validated['services'] as $service) {
            $serviceType = ServiceType::find($service['service_type_id']);
            $currency = strtolower($validated['currency']);

            $unitInstallationPrice = $serviceType->{"installation_price_$currency"};
            $unitMonthlyPrice = $serviceType->{"monthly_price_$currency"};

            $totalInstallationCost += $unitInstallationPrice * $service['quantity'];
            $totalMonthlyCost += $unitMonthlyPrice * $service['quantity'];
        }

        $contract->total_installation_cost = $totalInstallationCost;
        $contract->monthly_cost = $totalMonthlyCost;
        $contract->save();

        foreach ($validated['services'] as $service) {
            $serviceType = ServiceType::find($service['service_type_id']);
            $currency = strtolower($validated['currency']);

            $unitInstallationPrice = $serviceType->{"installation_price_$currency"};
            $unitMonthlyPrice = $serviceType->{"monthly_price_$currency"};

            ContractService::create([
                'contract_id' => $contract->id,
                'service_type_id' => $service['service_type_id'],
                'quantity' => $service['quantity'],
                'unit_installation_price' => $unitInstallationPrice,
                'unit_monthly_price' => $unitMonthlyPrice,
                'total_installation_cost' => $unitInstallationPrice * $service['quantity'],
                'total_monthly_cost' => $unitMonthlyPrice * $service['quantity'],
            ]);
        }

        return redirect()->route('contracts.index')->with('success', 'Contract created successfully');
    }

    public function show(Contract $contract)
    {
        $contract->load('client', 'contractServices.serviceType', 'installations.technician', 'installations.vehicle'); // Added 'installations.vehicle' load
        return view('contracts.show', compact('contract'));
    }

    // You will also need edit, update, and destroy methods for a full resource controller
    // Here are minimal placeholders:

    public function edit(Contract $contract)
    {
        $clients = Client::where('status', 'active')->get();
        $serviceTypes = ServiceType::where('is_active', true)->get();
        $contract->load('contractServices'); // Load services to pre-fill the form
        return view('contracts.edit', compact('contract', 'clients', 'serviceTypes'));
    }

    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'currency' => 'required|in:TZS,USD',
            'services' => 'required|array',
            'services.*.service_type_id' => 'required|exists:service_types,id',
            'services.*.quantity' => 'required|integer|min:1',
        ]);

        $contract->client_id = $validated['client_id'];
        $contract->start_date = $validated['start_date'];
        $contract->end_date = $validated['end_date'];
        $contract->currency = $validated['currency'];

        $totalInstallationCost = 0;
        $totalMonthlyCost = 0;

        // Sync services: first delete existing, then re-add
        $contract->contractServices()->delete();

        foreach ($validated['services'] as $service) {
            $serviceType = ServiceType::find($service['service_type_id']);
            $currency = strtolower($validated['currency']);

            $unitInstallationPrice = $serviceType->{"installation_price_$currency"};
            $unitMonthlyPrice = $serviceType->{"monthly_price_$currency"};

            $totalInstallationCost += $unitInstallationPrice * $service['quantity'];
            $totalMonthlyCost += $unitMonthlyPrice * $service['quantity'];

            ContractService::create([
                'contract_id' => $contract->id,
                'service_type_id' => $service['service_type_id'],
                'quantity' => $service['quantity'],
                'unit_installation_price' => $unitInstallationPrice,
                'unit_monthly_price' => $unitMonthlyPrice,
                'total_installation_cost' => $unitInstallationPrice * $service['quantity'],
                'total_monthly_cost' => $unitMonthlyPrice * $service['quantity'],
            ]);
        }

        $contract->total_installation_cost = $totalInstallationCost;
        $contract->monthly_cost = $totalMonthlyCost;
        $contract->save();

        return redirect()->route('contracts.index')->with('success', 'Contract updated successfully');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete(); // This will also cascade delete ContractServices if configured in migration
        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully');
    }
}
