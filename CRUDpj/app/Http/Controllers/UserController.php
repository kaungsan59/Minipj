<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Display all users
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.user', compact('users'));
    }

    // Show create user form
    public function create()
    {
        return view('admin.users');
    }

    // Store a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    // Show edit user form
    public function edit(User $user)
    {
        $users = User::latest()->get();

        return view('admin.user', compact('users', 'user'));
    }

    // Update user information
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make(
                $validated['password']
            );
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    // Delete a user
    public function destroy(User $user)
    {
        // Prevent deleting the currently logged-in account
        if (auth::id() === $user->id) {
            return redirect()
                ->route('users.index')
                ->withErrors([
                    'user' => 'You cannot delete your own account.'
                ]);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
