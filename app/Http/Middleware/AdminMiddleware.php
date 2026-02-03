<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // On vérifie si l'utilisateur est connecté ET s'il est Admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Si ce n'est pas un admin, on le renvoie au dashboard avec un message
        return redirect()->route('dashboard')->with('error', 'Accès réservé aux administrateurs.');
    }
}