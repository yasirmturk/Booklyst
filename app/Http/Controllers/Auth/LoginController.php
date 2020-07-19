<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\SocialAccount;
use App\Models\User;
use App\RegistersSocialAccounts;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Contracts\User as SocialUser;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

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

    use AuthenticatesUsers, RegistersSocialAccounts;

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
        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            Log::error($e);
            return redirect('/login')->withErrors(['feedback' => $e->getMessage()]);
        }
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            /** @var AbstractProvider $driver */
            $driver = Socialite::driver($provider);
            $pu = $driver->user(); // $pu->token;
            $account = SocialAccount::whereProvider($provider)
                ->whereProviderUserId($pu->getId())
                ->first();
            $user = $account ? $account->user : $this->createSocialAccount($provider, $pu)->user;
            $this->guard()->login($user);
            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect('/login')->withErrors(['feedback' => $e->getMessage()]);
        }
    }

    /**
     * @return \App\Models\User
     */
    public function createSocialAccount($provider, SocialUser $socialUser, $password = null)
    {
        $user = User::whereEmail($socialUser->getEmail())->first();
        if (!$user) {
            $user = User::create([
                'email' => $socialUser->getEmail(),
                'name' => $socialUser->getName(),
                'password' => Hash::make($password ?? str_random(10)),
            ]);
        }
        return $this->register($provider, $socialUser->getId(), $user);
    }
}
