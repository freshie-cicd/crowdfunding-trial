<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        if ('verification_pending' == auth()->user()->status) {
            return redirect('profile/edit')->with('message', 'You need to fill-up this form to get access.');
        }
        if ('blocked' == auth()->user()->status) {
            return redirect('profile/blocked')->with('message', 'Your Account is Blocked. Please Contact Customer Care');
        }

        return $next($request);
    }
}
