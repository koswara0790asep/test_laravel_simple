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
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        if (! $user) {
            // Redirect to login page if user is not logged in
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        foreach ($roles as $role) {
            // Check if user has the required role
            if ($user->role == $role) {
                // return redirect('/dashboard');
                return $next($request);
            }
        }

        abort(403, 'Akses Ditolak! Anda tidak memiliki hak akses ke halaman ini.');
        
        // return $next($request);
        // 1. Cek apakah user sudah login
        // if (!Auth::check()) {
        //     return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        // }

        // // 2. Cek apakah role user saat ini ada dalam daftar role yang diizinkan
        // $userRole = Auth::user()->role;
        // if (in_array($userRole, $roles)) {
        //     return $next($request); // Lanjutkan request ke controller
        // }

        // // 3. Jika role tidak sesuai, berikan respon akses ditolak (403)
        // abort(403, 'Akses Ditolak! Anda tidak memiliki hak akses ke halaman ini.');

    }
}
