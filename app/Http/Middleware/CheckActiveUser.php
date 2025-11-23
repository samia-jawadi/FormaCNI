<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // If user is not active (deactivated), logout and redirect
            if (!$user->est_actif) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect('/login')->withErrors([
                    'email' => 'Votre compte a été désactivé. Veuillez contacter l\'administrateur si vous pensez qu\'il s\'agit d\'une erreur.'
                ]);
            }
        }
        
        return $next($request);
    }
}
