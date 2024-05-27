<?php

// app/Http/Controllers/ValidatorController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Validator;

class ValidatorController extends Controller
{
    public function showAssignedEstimates()
    {
        // Get the logged-in validator
        $validator = Auth::user();

        // Fetch the estimates assigned to this validator
        $estimates = $validator->estimates; // Assuming the relationship is defined in the Validator model

        return view('validators.assigned_estimates', compact('estimates'));
    }
}


