<?php

namespace App\Providers;

use App\Http\Controllers\Auth\SocialGrant;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;

class SocialGrantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving(AuthorizationServer::class, function (AuthorizationServer $server) {
            $server->enableGrantType(
                $this->makeGrant(), Passport::tokensExpireIn()
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // migrations
        }
    }
    
    protected function makeGrant()
    {
        $grant = new SocialGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());
        
        return $grant;
    }
}
