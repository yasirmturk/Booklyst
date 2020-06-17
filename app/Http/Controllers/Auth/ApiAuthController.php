<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    private $client;

    /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $this->client = DB::table('oauth_clients')->where('id', 1)->first();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function authenticate(Request $request)
    {
        $request->request->add([
            'grant_type' => 'password',
            'username' => $request->email,
            'password' => $request->password,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => ''
        ]);

        $proxy = Request::create('oauth/token', 'POST');

        return \Route::dispatch($proxy);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function refreshToken(Request $request)
    {
        $request->request->add([
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }

    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'integer',
            //'client_id' => ['required', Rule::exists('oauth_clients', 'id')],
            // 'client_secret' => [
            //     'required',
            //     Rule::exists('oauth_clients', 'secret')->where('id', request()->get('client_id', 0))
            // ]
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $request['type'] = $request['type'] ? $request['type']  : 0;
        $user = User::create($request->toArray());
        $token = $user->createToken('Postman')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
        // $request->request->add([
        //     'grant_type' => 'password',
        //     'username' => $request['email'],
        //     'password' => $request['password'],
        //     'client_id' => $this->client->id,
        //     'client_secret' => $this->client->secret,
        //     'scope' => ''
        // ]);
        // $proxy = Request::create('oauth/token', 'POST');
        // return \Route::dispatch($proxy);
    }

    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
