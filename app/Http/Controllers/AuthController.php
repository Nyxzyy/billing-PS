<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            Log::info('User sudah login', ['user' => $user->toArray()]);
            
            if ($user->role && strtolower($user->role->name) === 'kasir') {
                return redirect('/kasir/dashboard');
            } elseif ($user->role && strtolower($user->role->name) === 'admin') {
                return redirect('/admin/dashboard');
            }
        }
        return view('login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            Log::info('Login berhasil', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]);
            
            $successMessage = 'Selamat datang, ' . $user->name . '!';
            
            if ($user->role && strtolower($user->role->name) === 'kasir') {
                Log::info('Redirecting to kasir dashboard');
                return redirect('/kasir/dashboard')->with('success', $successMessage);
            } elseif ($user->role && strtolower($user->role->name) === 'admin') {
                Log::info('Redirecting to admin dashboard');
                return redirect('/admin/dashboard')->with('success', $successMessage);
            }
            
            Log::warning('Role tidak dikenal', ['role' => $user->role]);
            return redirect('/login');
        }
    
        Log::info('Login gagal', ['email' => $request->email]);
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }
    
    public function logout(Request $request)
    {
        $user = Auth::user();
        Log::info('User logout', $user ? ['user_id' => $user->id] : []);
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}