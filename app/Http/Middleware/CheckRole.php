<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Enums\Roles;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string[]  ...$roles  // Variable number of required roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login'); // Not logged in
        }

        // CORRECTED: Access the integer role ID directly from the database column
        $userRole = (int) Auth::user()->role_id;

        // Check if the user's role matches any of the required roles
        if (! in_array($userRole, $roles)) {
            // User does not have the required role, redirect them safely
            return redirect()->route('dashboard')->with('error', 'Access denied. You do not have permission.');
        }

        return $next($request);
    }
}
