<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.manage_users', compact('users'));
    }

    public function store(Request $request)
    {
        // Validate and create a new user
        User::create($request->all());
        return back();
    }

    public function update(Request $request, User $user)
    {
        // Update user details
        $user->update($request->all());
        return back();
    }

    public function destroy(User $user)
    {
        // Delete a user
        $user->delete();
        return back();
    }
}
