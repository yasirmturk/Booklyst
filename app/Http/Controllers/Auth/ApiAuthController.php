<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    /**
     * ApiAuthController constructor.
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'integer',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $password = $request->password;
        $request['password'] = Hash::make($password);
        $request['remember_token'] = Str::random(10);
        $request['type'] = $request->type ?: 0;
        $user = User::create($request->toArray());
        // auth()->setUser($user);
        // $token = $user->createToken('Laravel Personal Access Client')->accessToken;
        // return response(['token' => $token]);
        $request->merge([
            'grant_type' => 'password',
            'scope' => '',
            'username' => $request->email,
            'password' => $password,
        ]);
        return $this->token();
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);
        $login = auth()->attempt([
            'email' => $loginData['username'],
            'password' => $loginData['password']
        ]);
        return $login ? $this->token() : response(['message' => 'Invalid Credentials'], 422);
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
