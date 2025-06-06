<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Installation; // <-- Add this line
use App\Models\Contract;     // <-- Add this line
use App\Models\ServiceType;  // <-- Add this line (needed for create/edit dropdowns potentially)
use App\Models\User;         // <-- Add this line

class InstallationController extends Controller
{
    public function index()
    {
        $installations = Installation::with('contract.client', 'serviceType', 'technician')->paginate(15);
        return view('installations.index', compact('installations'));
    }

    public function create()
    {
        $contracts = Contract::where('status', 'active')->with('client')->get();
        // You might want to filter service types as well if only certain ones are "installable"
        $serviceTypes = ServiceType::where('is_active', true)->get(); // Assuming 'is_active' field exists
        $technicians = User::where('role', 'technician')->where('is_active', true)->get();

        return view('installations.create', compact('contracts', 'serviceTypes', 'technicians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'service_type_id' => 'required|exists:service_types,id',
            'vehicle_plate_number' => 'required|string|max:20',
            'device_serial_number' => 'nullable|string|max:100',
            'installation_date' => 'required|date',
            'technician_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:scheduled,completed,failed', // Add status for initial creation
        ]);

        Installation::create($validated);
        return redirect()->route('installations.index')->with('success', 'Installation scheduled successfully');
    }

    public function edit(Installation $installation)
    {
        $contracts = Contract::where('status', 'active')->with('client')->get(); // Re-fetch for dropdown consistency if needed
        $serviceTypes = ServiceType::where('is_active', true)->get(); // Re-fetch for dropdown consistency if needed
        $technicians = User::where('role', 'technician')->where('is_active', true)->get();

        return view('installations.edit', compact('installation', 'contracts', 'serviceTypes', 'technicians'));
    }

    public function update(Request $request, Installation $installation)
    {
        $validated = $request->validate([
            // Contract_id and service_type_id are usually not updated after creation for an installation
            // If you want to allow changing them, you'd add them here
            'vehicle_plate_number' => 'required|string|max:20',
            'device_serial_number' => 'nullable|string|max:100',
            'installation_date' => 'required|date',
            'technician_id' => 'required|exists:users,id',
            'status' => 'required|in:scheduled,completed,failed',
            'notes' => 'nullable|string',
        ]);

        $installation->update($validated);
        return redirect()->route('installations.index')->with('success', 'Installation updated successfully');
    }

    public function destroy(Installation $installation)
    {
        $installation->delete();
        return redirect()->route('installations.index')->with('success', 'Installation deleted successfully.');
    }
}
