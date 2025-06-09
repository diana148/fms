<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Import PDF facade
use Carbon\Carbon; // For date manipulation

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure user is authenticated for all invoice actions
    }

    /**
     * Display a listing of the invoices.
     */
    public function index()
    {
        $invoices = Invoice::with('client', 'contract')
                            ->latest() // Order by latest invoices first
                            ->paginate(15);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Generate monthly invoices for eligible contracts.
     */
    public function generateMonthlyInvoices(Request $request)
    {
        $generatedCount = 0;
        $currentMonth = Carbon::now()->startOfMonth();
        $nextMonth = Carbon::now()->addMonth()->startOfMonth();

        // Find active contracts that have monthly costs
        $eligibleContracts = Contract::where('status', 'active')
            ->where('monthly_cost', '>', 0)
            ->where('end_date', '>=', $currentMonth) // Contract must be active for the current month
            ->with(['client', 'installations']) // Eager load client and installations
            ->get();

        DB::beginTransaction();
        try {
            foreach ($eligibleContracts as $contract) {
                // Check if client is active
                if ($contract->client->status !== 'active') {
                    continue;
                }

                // Check if there's at least one completed installation for this contract
                $hasCompletedInstallation = $contract->installations->contains('status', 'completed');

                if (!$hasCompletedInstallation) {
                    continue; // Skip if no completed installation
                }

                // Check if an invoice for this contract for the current month already exists
                $existingInvoice = Invoice::where('contract_id', $contract->id)
                    ->whereYear('invoice_date', $currentMonth->year)
                    ->whereMonth('invoice_date', $currentMonth->month)
                    ->first();

                if ($existingInvoice) {
                    continue; // Skip if invoice already generated for this month
                }

                // Generate a unique invoice number
                $invoiceNumber = 'INV-' . $currentMonth->format('Ym') . '-' . str_pad($contract->id, 5, '0', STR_PAD_LEFT);

                Invoice::create([
                    'invoice_number' => $invoiceNumber,
                    'client_id' => $contract->client_id,
                    'contract_id' => $contract->id,
                    'invoice_date' => $currentMonth, // Invoice date is the start of the current month
                    'due_date' => $nextMonth->addDays(7), // Due date is 7 days into the next month
                    'amount_tzs' => $contract->currency === 'TZS' ? $contract->monthly_cost : 0,
                    'amount_usd' => $contract->currency === 'USD' ? $contract->monthly_cost : 0,
                    'status' => 'pending',
                    'notes' => 'Monthly recurring invoice for ' . $currentMonth->format('F Y'),
                ]);
                $generatedCount++;
            }

            DB::commit();
            return redirect()->route('invoices.index')->with('success', "$generatedCount monthly invoices generated successfully.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('invoices.index')->with('error', 'Error generating invoices: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('client', 'contract.contractServices.serviceType');
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Download the specified invoice as PDF.
     */
    public function downloadInvoice(Invoice $invoice)
    {
        $invoice->load('client', 'contract.contractServices.serviceType');

        // You might want a dedicated blade view for the PDF layout (e.g., invoices.pdf_template)
        $pdf = Pdf::loadView('invoices.show', compact('invoice')); // Using the same show view for simplicity

        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
