<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Installation;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();
        $activeContracts = Contract::where('status', 'active')->count();
        $pendingInstallations = Installation::where('status', 'scheduled')->count();
        $monthlyRevenue = Contract::where('status', 'active')->sum('monthly_cost');

        return view('dashboard', compact(
            'totalClients', 'activeContracts', 'pendingInstallations', 'monthlyRevenue'
        ));
    }

}
