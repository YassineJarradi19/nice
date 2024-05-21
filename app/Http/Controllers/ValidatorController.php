<?php

// app/Http/Controllers/ValidatorController.php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Estimates;
use App\Models\UserValidatorAssignment;
use App\Models\User;

class ValidatorController extends Controller
{
    public function sendEstimate(Request $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Get the validators assigned to this user
        $validators = UserValidatorAssignment::where('user_id', $user->id)->pluck('validator_id');

        // Get the estimate details
        $estimate = Estimates::find($request->input('estimate_id'));

        // Loop through each validator and perform necessary actions
        foreach ($validators as $validator_id) {
            // You might want to send a notification or create a record for each validator
            // Example: Notification::send(User::find($validator_id), new EstimateNotification($estimate));
        }

        return redirect()->back()->with('success', 'Estimate sent to validators successfully.');
    }

    public function requests()
    {
        
        return view('validator.requests');
    }
}
