<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (Auth::check()) {
            // Retrieve the authenticated user
            $user = $request->user();

            // Check if the user has any of the specified roles
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    return $next($request);
                }
            }
        }

        // Redirect to a specific route if user does not have the required role
        return redirect('/');
    }
}
