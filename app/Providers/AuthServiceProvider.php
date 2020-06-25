<?php

namespace App\Providers;

use App\Permissions;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerGates();

        $this->preparePassport();
    }

    private function registerGates()
    {
        Gate::define('super-admin', function($user) {
            return $user->hasRole(Permissions::ROLE_SUPER_ADMIN);
        });

        Gate::define('admin', function($user) {
            return $user->hasRole(Permissions::ROLE_ADMIN);
        });
    }

    private function preparePassport() {
        Passport::routes();//null, ['prefix' => 'api/oauth']

        // Passport::personalAccessClientId(config('passport.personal_access_client.id'));

        // Passport::personalAccessClientSecret(config('passport.personal_access_client.secret'));

        Passport::tokensCan([
            'place-orders' => 'Place orders',
            'check-status' => 'Check order status',
        ]);

        // Passport::enableImplicitGrant();

        Passport::tokensExpireIn(now()->addDays(1));

        Passport::refreshTokensExpireIn(now()->addDays(30));

        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
