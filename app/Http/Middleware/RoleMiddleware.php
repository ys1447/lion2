<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Pastikan ini di-import

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  <-- Tambahkan parameter ini
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login menggunakan Facade Auth
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil user yang sedang login
        $user = Auth::user();

        // 3. Cek apakah role user sama dengan yang diminta di Route
        // Pastikan kolom di database Anda namanya 'role'
        if ($user->role !== $role) {
            // Jika bukan admin (atau role yang diminta), lempar ke dashboard
            return redirect('/dashboard')->with('error', 'Akses Terbatas!');
        }

        return $next($request);
    }
}