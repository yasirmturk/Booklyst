<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

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
            $user = $request->user();
            $customer = $user->createOrGetStripeCustomer();
            $response->setContent([
                'token' => json_decode($response->getContent()),
                'user' => array_merge($user->toArray(), [
                    'hasPaymentMethod' => $user->hasPaymentMethod()
                ]),
                'subscriptions' => $customer->subscriptions->data
            ]);
        }
        return $response;
    }
}
