<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    public static function createOrGetUser($provider, $providerUser, $email, $name)
    {
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser)
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser,
                'provider' => $provider
            ]);
            $user = User::whereEmail($email)->first();
            if (!$user) {
                $user = User::create([
                    'email' => $email,
                    'name' => $name,
                    'password' => md5(rand(1, 10000)),
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}
