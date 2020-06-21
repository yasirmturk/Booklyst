<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\SocialAccount;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as ProviderUser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request, $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $fbUser = Socialite::driver($provider)->user(); // $fbUser->token;
            $user = $this->createOrGetUser($fbUser, $provider);
            auth()->login($user);
            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([$e->getMessage()]);
        }
    }

    /**
     * @return \App\User
     */
    private function createOrGetUser(ProviderUser $providerUser, $provider)
    {
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);
            $user = User::whereEmail($providerUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1, 10000)),
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}
