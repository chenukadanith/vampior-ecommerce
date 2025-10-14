<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;



class UserController extends Controller
{
    //
    public function index()
    {
        // Get all users and eager load their roles to prevent N+1 issues
        $users = User::with('roles')->get();

        // Get all available roles to populate the dropdown
        $roles = Role::all();

        // Pass the users and roles to the view
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Update the specified user's role in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate that the selected role exists
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Use syncRoles to remove all old roles and apply the new one
        $user->syncRoles($request->role);

        return redirect()->route('admin.users.index')->with('success', 'User role updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent the admin from deleting their own account
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
