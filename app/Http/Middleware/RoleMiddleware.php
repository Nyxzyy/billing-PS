<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (strtolower($user->role->name) !== strtolower($role)) {
            // Redirect based on user's actual role
            return match (strtolower($user->role->name)) {
                'admin' => redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                'kasir' => redirect()->route('kasir.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                default => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}
