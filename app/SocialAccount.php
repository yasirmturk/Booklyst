<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\User as ProviderUser;

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
    public static function createOrGetUser($provider, ProviderUser $providerUser, $password)
    {
        $userId = $providerUser->getId();
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($userId)
            ->first();
        if ($account) {
            $user = $account->user;
            $user->password = Hash::make($password);
            $user->save();
            return $user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $userId,
                'provider' => $provider
            ]);
            $user = User::whereEmail($providerUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => Hash::make($password),
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}
