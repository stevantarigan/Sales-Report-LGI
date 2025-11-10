<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek jika user belum login
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        $userRole = $user->role;

        // Cek jika user role ada dalam list roles yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized access. Your role: ' . $userRole . '. Required roles: ' . implode(', ', $roles));
    }
}