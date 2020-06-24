<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use App\User;
use App\SocialAccount;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

class ApiAuthController extends RegisterController
{

    use AuthenticatesUsers {
        login as protected authenticate;
    }

    /**
     * ApiAuthController constructor.
     */
    public function __construct()
    {
        //
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
        return $this->token();
    }

    public function loginProvider(Request $request, $provider)
    {
        // $validator = Validator::make($request->all(), [
        //     'access_token' => 'required|string',
        // ]);
        // if ($validator->fails()) {
        //     return response(['errors' => $validator->errors()->all()], 422);
        // }

        // /** @var AbstractProvider $driver */
        // $driver = Socialite::driver($provider);
        // $pu = $driver->userFromToken($request->access_token);
        // $password = str_random(10);
        // Log::debug("Generating new password: $password");
        // $user = SocialAccount::createOrGetUser($provider, $pu, $password);
        // auth()->setUser($user);
        // $token = $user->createToken('Turkly PAC')->accessToken;
        // return response(['token' => $token]);
        $request->merge([
            'provider' => $provider,
            'grant_type' => 'social',
            // 'username' => $pu->getEmail(),
            // 'password' => $password,
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
