<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceType; // <-- Add this line

class ServiceTypeController extends Controller
{
    public function index()
    {
        $serviceTypes = ServiceType::all();
        return view('service-types.index', compact('serviceTypes'));
    }

    public function create()
    {
        return view('service-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'installation_price_tzs' => 'required|numeric|min:0',
            'installation_price_usd' => 'required|numeric|min:0',
            'monthly_price_tzs' => 'required|numeric|min:0',
            'monthly_price_usd' => 'required|numeric|min:0',
            'is_active' => 'boolean', // Added validation for is_active
        ]);

        ServiceType::create($validated);
        return redirect()->route('service-types.index')->with('success', 'Service type created successfully');
    }

    public function edit(ServiceType $serviceType)
    {
        return view('service-types.edit', compact('serviceType'));
    }

    public function update(Request $request, ServiceType $serviceType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'installation_price_tzs' => 'required|numeric|min:0',
            'installation_price_usd' => 'required|numeric|min:0',
            'monthly_price_tzs' => 'required|numeric|min:0',
            'monthly_price_usd' => 'required|numeric|min:0',
            'is_active' => 'boolean', // Added validation for is_active
        ]);

        $serviceType->update($validated);
        return redirect()->route('service-types.index')->with('success', 'Service type updated successfully');
    }

    public function destroy(ServiceType $serviceType)
    {
        $serviceType->delete();
        return redirect()->route('service-types.index')->with('success', 'Service type deleted successfully.');
    }
}
