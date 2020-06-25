<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Socialite\Contracts\User as SocialUser;
use Laravel\Socialite\Facades\Socialite;

class SocialAccountRepository extends UserRepository implements SocialUserRepositoryInterface
{
    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */
    public function userByProviderCredentials(string $provider, string $accessToken): ?Authenticatable
    {
        // Return the user that corresponds to provided credentials.
        // If the credentials are invalid, then return NULL.
        /** @var AbstractProvider $driver */
        $driver = Socialite::driver($provider);
        $pu = $driver->userFromToken($accessToken);
        return SocialAccount::createOrGetUser($provider, $pu);
    }
}

class SocialAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    /**
     * Get associated User.
     * @return \App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \App\User
     */
    public static function createOrGetUser($provider, SocialUser $socialUser, $password = null)
    {
        $userId = $socialUser->getId();
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($userId)
            ->first();
        if ($account) {
            $user = $account->user;
            $user->save();
            return $user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $userId,
                'provider' => $provider
            ]);
            $user = User::whereEmail($socialUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'email' => $socialUser->getEmail(),
                    'name' => $socialUser->getName(),
                    'password' => Hash::make($password ?? str_random(10)),
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}
