<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AuthUserApi
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
        $response = $next($request);
        if ($response->isOk()) {
            $response->setContent([
                'token' => json_decode($response->getContent()),
                'user' => User::where('email', $request->username)->first()
            ]);
        }
        return $response;
    }
}
