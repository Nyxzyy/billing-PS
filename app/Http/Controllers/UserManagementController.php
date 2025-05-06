<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $kasirRole = Role::where('name', 'kasir')->first();
        $query = User::with('role')->where('role_id', $kasirRole->id);

        $users = $query->paginate(10);
        $roles = Role::where('name', 'kasir')->get();

        return view('admin.manageUser', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::where('role_id', 2)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('phone_number', 'LIKE', "%{$query}%")
                  ->orWhere('address', 'LIKE', "%{$query}%");
            })
            ->paginate(10);

        return response()->json([
            'html' => view('admin.partials.manageUser-table', compact('users'))->render()
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::defaults()],
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $validated['role_id'] = $request->role_id ?? 2;
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.manageUser')
            ->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', Password::defaults()]
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $validated['role_id'] = $request->role_id ?? 2;
        $user->update($validated);

        return redirect()->route('admin.manageUser')
            ->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.manageUser')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        }

        $user->delete();

        return redirect()->route('admin.manageUser')
            ->with('success', 'Pengguna berhasil dihapus');
    }
}
