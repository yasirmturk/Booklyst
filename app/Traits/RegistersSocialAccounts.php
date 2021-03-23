<?php

namespace App\Traits;

use App\Models\SocialAccount;
use App\Models\User;

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
