<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

        if (!Auth::guard('administrator')->check()) {
            return redirect('home')->with('error', 'You do not have access to this section.');
        }

        if (!Auth::guard('administrator')->user()->hasRole($role)) {
            return redirect()->route('administrator.unauthorized');
        }

        return $next($request);
    }
}
