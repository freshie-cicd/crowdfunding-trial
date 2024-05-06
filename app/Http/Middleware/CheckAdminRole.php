<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @param mixed                                                                            $role
     */
    public function handle(Request $request, \Closure $next, $role): Response
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
