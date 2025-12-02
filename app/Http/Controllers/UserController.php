<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // HAPUS CONSTRUCTOR, gunakan route middleware

    public function index()
    {
        // Manual check auth dan role
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/dashboard')->with('error', 'Unauthorized access.');
        }

        $users = User::where('role', '!=', 'admin')
            ->withCount('articles')
            ->latest()
            ->get();

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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'staff';

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'Staff member created successfully.');
    }

    public function show(User $user)
    {
        $articles = $user->articles()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('users.show', compact('user', 'articles'));
    }

    public function edit(User $user)
    {
        // Manual check auth dan role
        if (!Auth::check() || (!Auth::user()->isAdmin() && Auth::id() !== $user->id)) {
            return redirect('/dashboard')->with('error', 'Unauthorized access.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Manual check auth dan role
        if (!Auth::check() || (!Auth::user()->isAdmin() && Auth::id() !== $user->id)) {
            return redirect('/dashboard')->with('error', 'Unauthorized access.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Add password validation only if password is provided
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        // Only admins can change roles
        if (Auth::user()->isAdmin()) {
            $rules['role'] = 'required|in:user,staff,admin';
        }

        $request->validate($rules);

        $data = $request->except(['password', 'password_confirmation']);

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
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
            return redirect()->route('users.index')
                ->with('error', 'Cannot delete admin user.');
        }

        // Delete user's avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('users.index')
                ->with('error', 'Cannot restore admin user.');
        }

        $user->restore();

        return redirect()->route('users.index')
            ->with('success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('users.index')
                ->with('error', 'Cannot delete admin user.');
        }

        // Delete user's articles and images
        foreach ($user->articles as $article) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
        }

        // Delete user's avatar
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->forceDelete();

        return redirect()->route('users.index')
            ->with('success', 'User permanently deleted.');
    }

    public function trash()
    {
        $users = User::onlyTrashed()
            ->where('role', '!=', 'admin')
            ->latest()
            ->get();

        return view('users.trash', compact('users'));
    }
}
