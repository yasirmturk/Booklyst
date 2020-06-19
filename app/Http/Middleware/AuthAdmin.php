<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
// use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard()->check() && $request->user()->type >= 1) {
            return $next($request);
        } else {
            // $message = ["message" => "Permission Denied"];
            // return response($message, 401);
            // Auth::logout();
            // throw new AuthenticationException('Unauthenticated.', [Auth::guard()], route('home'));
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
