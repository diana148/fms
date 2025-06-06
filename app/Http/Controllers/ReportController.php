<?php

namespace App\Http\Controllers; // <-- Ensure this namespace is correct

use App\Models\Client;
use App\Models\Contract;
use App\Models\Installation;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function __construct()
    {
        // Apply 'auth' middleware to all methods in this controller
        // Apply 'download-reports' gate to only the download methods
        $this->middleware('auth');
        $this->middleware('can:download-reports')->only([
            'downloadClientsReport',
            'downloadContractsReport',
            'downloadInstallationsReport',
            'downloadContractsByServiceTypeReport'
        ]);
    }

    /**
     * Display the main reports dashboard.
     */
    public function index()
    {
        // --- Client Reports ---
        $totalClients = Client::count();
        $activeClients = Client::where('status', 'active')->count();
        $inactiveClients = Client::where('status', 'inactive')->count();

        // --- Contract Reports ---
        $totalContracts = Contract::count();
        $activeContracts = Contract::where('status', 'active')->count();
        $expiredContracts = Contract::where('end_date', '<', now())->count();
        $contractsExpiringSoon = Contract::where('end_date', '>', now())
                                        ->where('end_date', '<=', now()->addDays(30))
                                        ->count();

        // Contracts by Service Type (Example)
        $contractsByServiceType = ServiceType::withCount('contractServices')->get();

        // --- Installation Reports ---
        $totalInstallations = Installation::count();
        $pendingInstallations = Installation::where('status', 'pending')->count();
        $completedInstallations = Installation::where('status', 'completed')->count();
        $cancelledInstallations = Installation::where('status', 'cancelled')->count();

        // Installations by Status (Example)
        $installationsByStatus = Installation::select('status', \DB::raw('count(*) as count'))
                                            ->groupBy('status')
                                            ->get();


        return view('reports.index', compact(
            'totalClients',
            'activeClients',
            'inactiveClients',
            'totalContracts',
            'activeContracts',
            'expiredContracts',
            'contractsExpiringSoon',
            'contractsByServiceType',
            'totalInstallations',
            'pendingInstallations',
            'completedInstallations',
            'cancelledInstallations',
            'installationsByStatus'
        ));
    }

    /**
     * Downloads a CSV report of all clients.
     */
    public function downloadClientsReport()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="clients_report_' . date('Ymd_His') . '.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Company Name', 'Contact Person', 'Phone', 'Email', 'Address', 'Status', 'Created At']); // CSV Headers

            Client::chunk(100, function ($clients) use ($file) {
                foreach ($clients as $client) {
                    fputcsv($file, [
                        $client->id,
                        $client->company_name,
                        $client->contact_person,
                        $client->phone,
                        $client->email,
                        $client->address,
                        $client->status,
                        $client->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Downloads a CSV report of all contracts.
     */
    public function downloadContractsReport()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contracts_report_' . date('Ymd_His') . '.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID', 'Contract Number', 'Client Company Name', 'Start Date', 'End Date',
                'Status', 'Total Price (TZS)', 'Total Price (USD)', 'Created At'
            ]); // CSV Headers

            Contract::with('client')->chunk(100, function ($contracts) use ($file) {
                foreach ($contracts as $contract) {
                    fputcsv($file, [
                        $contract->id,
                        $contract->contract_number,
                        $contract->client->company_name ?? 'N/A', // Assuming client relationship exists
                        $contract->start_date->format('Y-m-d'),
                        $contract->end_date->format('Y-m-d'),
                        $contract->status,
                        $contract->total_price_tzs,
                        $contract->total_price_usd,
                        $contract->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Downloads a CSV report of all installations.
     */
    public function downloadInstallationsReport()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="installations_report_' . date('Ymd_His') . '.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID', 'Client Company Name', 'Contract Number', 'Service Type',
                'Installation Date', 'Status', 'Notes', 'Created At'
            ]); // CSV Headers

            Installation::with(['client', 'contract', 'serviceType'])->chunk(100, function ($installations) use ($file) {
                foreach ($installations as $installation) {
                    fputcsv($file, [
                        $installation->id,
                        $installation->client->company_name ?? 'N/A',
                        $installation->contract->contract_number ?? 'N/A',
                        $installation->serviceType->name ?? 'N/A',
                        $installation->installation_date->format('Y-m-d'),
                        $installation->status,
                        $installation->notes,
                        $installation->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Downloads a CSV report of contracts grouped by service type.
     */
    public function downloadContractsByServiceTypeReport()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contracts_by_service_type_report_' . date('Ymd_His') . '.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Service Type', 'Number of Contracts']); // CSV Headers

            $contractsByServiceType = ServiceType::withCount('contractServices')->get();

            foreach ($contractsByServiceType as $serviceType) {
                fputcsv($file, [
                    $serviceType->name,
                    $serviceType->contractServices_count,
                ]);
            }
            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
