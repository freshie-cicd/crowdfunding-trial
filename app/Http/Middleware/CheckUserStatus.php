<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(auth()->user()->status == 'verification_pending'){
            return redirect('profile/edit')->with('message', 'You need to fill-up this form to get access.');
        }elseif(auth()->user()->status == 'blocked'){
            return redirect('profile/blocked')->with('message', 'Your Account is Blocked. Please Contact Customer Care');
        }

        return $next($request);
    }
}
