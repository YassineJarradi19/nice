<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Hash;
use DB;
use Carbon\Carbon;
use App\Models\Validator; // Make sure this model is correctly defined
class UserController extends Controller
 { 
    public function index(Request $request)
    {
        $query = User::query();

        // Apply filters
        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('prenom') && !empty($request->prenom)) {
            $query->where('prenom', 'like', '%' . $request->prenom . '%');
        }

        if ($request->has('role_name') && !empty($request->role_name)) {
            $query->where('role_name', 'like', '%' . $request->role_name . '%');
        }

        if ($request->has('admin') && !is_null($request->admin)) {
            $query->where('admin', $request->admin);
        }

        // Additional filters can be added here

        $users = $query->with('validators')->get();

        return view('admin.manage', compact('users'));
    }

    

    
    public function create()
    {
        $role = DB::table('role_type_users')->get(); // Ensure this table and data exist
        return view('admin.create', compact('role'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'sometimes|numeric',
            'role_name' => 'required|string',
            'position' => 'sometimes|string|max:255',
            'department' => 'sometimes|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'admin' => 'required|in:yes,no',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'role_name' => $request->role_name,
            'status' => 'Active',
            'position' => $request->position,
            'department' => $request->department,
            'password' => Hash::make($request->password),
            'join_date' => $request->join_date ?? now(),
            'admin' => $request->admin === 'yes',
        ]);
    
        // Automatically add to validators table if role is 'validator'
        if ($request->role_name == 'Validateur') {
            Validator::updateOrCreate(['email' => $user->email], ['name' => $user->name, 'email' => $user->email]);
        }
    
        Toastr::success('User created successfully!', 'Success');
        return response()->json(['success' => true, 'message' => 'User created successfully!']);
    }
    
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // Assume similar validation as store method
        $user->update($request->all());
    
        if ($user->role_name == 'Validateur') {
            Validator::updateOrCreate(['email' => $user->email], ['name' => $user->name, 'email' => $user->email]);
        } else {
            // Optionally remove from validators table if not a validator anymore
            Validator::where('email', $user->email)->delete();
        }
    
        Toastr::success('User updated successfully!', 'Success');
        return response()->json(['success' => true, 'message' => 'User updated successfully!']);
    }
    

  


    public function modifyValidators($id)
    {
        $user = User::findOrFail($id);
        $assignedValidators = $user->validators; // Get the validators assigned to the user
        $assignedValidatorIds = $assignedValidators->pluck('id')->toArray();

        // Exclude already assigned validators from the list of available validators
        $validators = Validator::whereNotIn('id', $assignedValidatorIds)->get();

        return view('admin.modify_validators', compact('user', 'validators', 'assignedValidators'));
    }

    public function updateValidators(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Attach new validators to the already assigned ones
        $user->validators()->attach($request->validators);

        return redirect()->route('modify.validators', $user->id)->with('success', 'Validators added successfully');
    }

    public function removeValidator(Request $request, $userId, $validatorId)
    {
        $user = User::findOrFail($userId);
        $user->validators()->detach($validatorId);

        return redirect()->route('modify.validators', $user->id)->with('success', 'Validator removed successfully');
    }












}