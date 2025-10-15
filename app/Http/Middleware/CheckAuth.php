<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si un utilisateur est connecté via "web" ou "collaborateur"
        if (Auth::guard('web')->check() || Auth::guard('collaborateur')->check()) {
            return $next($request);
        }

        // Si session expirée OU utilisateur non connecté
        return redirect()->route('login.show')
            ->with('error', 'Votre session a expiré, veuillez vous reconnecter.');
    }
}
