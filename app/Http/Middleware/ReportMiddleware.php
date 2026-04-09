<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ReportMiddleware
{


    /**
     *
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the authenticated user has the 'field_staff' role
            if (Auth::user()->role === 'field_staff' || Auth::user()->role === 'hq_staff') {
                return $next($request); // Allow access to the route
            }
        }

        // If the user is not an field staff, redirect to home or another page
        return redirect('/home')->with('error', 'Access denied. Admins only.');
    }
}
