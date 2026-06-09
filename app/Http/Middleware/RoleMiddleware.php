<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Memeriksa apakah user yang login memiliki role yang diizinkan.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Role yang diizinkan (bisa lebih dari satu)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah role user termasuk dalam daftar yang diizinkan
        if (!in_array(auth()->user()->role, $roles)) {
            // Log percobaan akses tidak sah
            \Log::warning('Unauthorized access attempt', [
                'user_id' => auth()->id(),
                'username' => auth()->user()->username,
                'role' => auth()->user()->role,
                'attempted_url' => $request->fullUrl(),
                'ip' => $request->ip(),
            ]);

            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
