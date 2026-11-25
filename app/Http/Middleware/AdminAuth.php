<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Checks if user is logged in AND is an admin
        if (!session()->has('user_id') || session('role') !== 'admin') {
            return redirect('/login')->with('error', 'Please log in as an admin first.');
        }

        return $next($request);
    }
}