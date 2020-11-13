<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;

class AuthController extends RegisterController
{
    use AuthenticatesUsers {
        login as protected authenticate;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $stripeCustomer = $user->createAsStripeCustomer();
        $request->merge([
            'grant_type' => 'password',
            'scope' => '*',
            'username' => $request->email
        ]);
        return $this->token();
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        return $this->token();
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $request->merge([
            'email' => $request->username
        ]);
        return $this->authenticate($request);
    }

    public function loginSocial(Request $request)
    {
        $request->merge([
            'grant_type' => 'social',
            'scope' => '*',
        ]);
        return $this->token();
    }

    public function loginProvider(Request $request, $provider)
    {
        // auth()->setUser($user);
        // $token = $user->createToken('Turkly PAC')->accessToken;
        // return response(['token' => $token]);
        $request->merge([
            'provider' => $provider,
        ]);
        return $this->token();
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    private function token()
    {
        $proxy = Request::create('oauth/token', 'POST');
        return Route::dispatch($proxy);
    }
}
