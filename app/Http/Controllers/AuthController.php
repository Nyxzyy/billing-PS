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
    
            $redirectUrl = strtolower($user->role->name) === 'kasir' ? '/kasir/dashboard' : '/admin/dashboard';
    
            return response()->json([
                'success' => true,
                'message' => 'Selamat datang, ' . $user->name . '!',
                'redirect' => $redirectUrl
            ]);
        }
    
        return response()->json([
            'success' => false,
            'errors' => ['email' => 'Email atau password salah.']
        ], 401);
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