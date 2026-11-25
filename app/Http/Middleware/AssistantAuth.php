<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssistantAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Checks if user is logged in AND is an assistant
        if (!session()->has('user_id') || session('role') !== 'assistant') {
            return redirect('/login')->with('error', 'Please log in as an assistant first.');
        }

        return $next($request);
    }
}