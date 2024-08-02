<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estimates;
use Illuminate\Support\Facades\Auth;

class DemanderecuController extends Controller
{
    public function index()
    {
     // Fetch all estimates with status 'validation partielle', 'commander', or 'livrer'
     $statuses = ['Validée', 'Commandé', 'Livré','Reçu','Refusée','En cours de traitement'];
     $estimates = Estimates::whereIn('status', $statuses)->get();
    
        // Pass the estimates to the view
        return view('acheteur.demanderecu', compact('estimates'));
    }
    public function indexACH(Request $request)
{
    $query = Estimates::query();

    // Filter by type of demand
    if ($request->filled('type_demande')) {
        $query->where('type_demande', $request->type_demande);
    }

    // Filter by date range
    if ($request->filled('date_from')) {
        $query->whereDate('estimate_date', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('expiry_date', '<=', $request->date_to);
    }

    // Filter by status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Fetch the results with pagination
    $estimates = $query->whereIn('status', ['Validée', 'Livré', 'Refusée', 'En cours de traitement', 'Commandé', 'Reçu']);

    
    return view('acheteur.demanderecu', compact('estimates'));
}



}
