<?php

/**
 * OAuth Social User Repository.
 *
 * @author      Yasir M Türk <yasirmturk@gmail.com>
 * @copyright   Copyright (c) Yasir M Türk
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/yasirmturk/social-grant
 */

namespace App;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Socialite\Contracts\User as SocialUser;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

trait RegistersSocialAccounts
{

    /**
     * Handle a registration request for the application.
     *
     * @return \App\Models\SocialAccount
     */
    public function register(string $provider, string $id, User $user)
    {
        $account = new SocialAccount([
            'provider_user_id' => $id,
            'provider' => $provider
        ]);
        $account->user()->associate($user);
        $account->save();
        return $account;
    }
}

class SocialAccountRepository extends UserRepository implements SocialAccountRepositoryInterface
{
    use RegistersSocialAccounts;
    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */
    public function userByProviderCredentials(string $provider, string $accessToken, $callback): ?Authenticatable
    {
        // Return the user that corresponds to provided credentials.
        // If the credentials are invalid, then return NULL.
        /** @var AbstractProvider $driver */
        $driver = Socialite::driver($provider);
        $pu = $driver->userFromToken($accessToken);
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($pu->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = $this->createSocialAccount($provider, $pu);
            $callback($account->user);
            return $account->user;
        }
    }

    public function registered($request, $user)
    {
        if ($user instanceof User) {
            $params = (array) $request->getParsedBody();
            foreach ($params['roles'] ?? [] as $role) {
                $user->addRole($role);
            }
            $user->save();
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
