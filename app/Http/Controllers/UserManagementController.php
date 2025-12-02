<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->withCount('articles')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function createStaff()
    {
        return view('users.create-staff');
    }

    public function storeStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        return redirect()->route('users.index')->with('success', 'Staff created.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ];

        // Add password validation only if password is provided
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        // Only admins can change roles
        if (Auth::user()->isAdmin()) {
            $rules['role'] = 'required|in:user,staff';
        }

        $request->validate($rules);

        $data = $request->except(['password', 'password_confirmation']);

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Only admins can change roles
        if (Auth::user()->isAdmin()) {
            $data['role'] = $request->role;
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('users.index')->with('error', 'Cannot delete admin.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
    public function export()
    {
        $filename = 'users-' . date('Y-m-d-H-i-s') . '.xlsx';
        return Excel::download(new UsersExport(), $filename);
    }
}
