<?php

/**
 * OAuth Social Account Repository Interface.
 *
 * @author      Yasir M Türk <yasirmturk@gmail.com>
 * @copyright   Copyright (c) Yasir M Türk
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/yasirmturk/social-grant
 */

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;

interface SocialAccountRepositoryInterface extends UserRepositoryInterface
{
    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     * @param  \Closure $callback
     *
     * @return Authenticatable|null
     */
    public function userByProviderCredentials(string $provider, string $accessToken, $callback): ?Authenticatable;

    /**
     * The user has been registered.
     *
     * @param ServerRequestInterface $request
     * @param Authenticatable $user
     *
     * @return mixed
     */
    public function registered(ServerRequestInterface $request, Authenticatable $user);
}
