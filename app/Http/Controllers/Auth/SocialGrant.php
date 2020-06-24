<?php
/**
 * OAuth Social grant.
 *
 * @author      Yasir M Türk <yasirmturk@gmail.com>
 * @copyright   Copyright (c) Yasir M Türk
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/yasirmturk/social-grant
 */

namespace App\Http\Controllers\Auth;

use App\SocialAccount;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Passport\Bridge\User as UserEntity;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\RequestEvent;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Social grant class.
 */
class SocialGrant extends PasswordGrant
{
    /**
     * @param ServerRequestInterface $request
     * @param ClientEntityInterface  $client
     *
     * @throws OAuthServerException
     *
     * @return UserEntityInterface
     */
    protected function validateUser(ServerRequestInterface $request, ClientEntityInterface $client)
    {
        $access_token = $this->getRequestParameter('access_token', $request);

        if (\is_null($access_token)) {
            throw OAuthServerException::invalidRequest('access_token');
        }

        $provider = $this->getRequestParameter('provider', $request);

        if (\is_null($provider)) {
            throw OAuthServerException::invalidRequest('provider');
        }

        /** @var AbstractProvider $driver */
        $driver = Socialite::driver($provider);
        $pu = $driver->userFromToken($access_token);
        $user = SocialAccount::createOrGetUser($provider, $pu);

        if ($user instanceof Authenticatable) {
            $user = new UserEntity($user->getAuthIdentifier());
        }

        if ($user instanceof UserEntityInterface === false) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::USER_AUTHENTICATION_FAILED, $request));

            throw OAuthServerException::invalidGrant();
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return 'social';
    }
}
