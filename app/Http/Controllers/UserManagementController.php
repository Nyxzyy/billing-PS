<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        // Get the Kasir role ID
        $kasirRole = Role::where('name', 'kasir')->first();
        
        $query = User::with('role')->where('role_id', $kasirRole->id);

        // Handle search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Get paginated results
        $users = $query->paginate(10);
        $roles = Role::where('name', 'kasir')->get();

        return view('admin.manageUser', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::defaults()],
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);

        return redirect()->route('admin.manageUser')
            ->with('success', 'Pengguna berhasil ditambahkan');
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id'
        ]);

        // Only update password if it's provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', Password::defaults()]
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.manageUser')
            ->with('success', 'Pengguna berhasil diperbarui');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.manageUser')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        }

        $user->delete();

        return redirect()->route('admin.manageUser')
            ->with('success', 'Pengguna berhasil dihapus');
    }
}
