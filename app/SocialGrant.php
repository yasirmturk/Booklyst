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

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Passport\Bridge\User as UserEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use League\OAuth2\Server\RequestEvent;
use Psr\Http\Message\ServerRequestInterface;

interface SocialUserRepositoryInterface extends UserRepositoryInterface
{
    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */
    public function userByProviderCredentials(string $provider, string $accessToken): ?Authenticatable;
}

/**
 * Social grant class.
 */
class SocialGrant extends PasswordGrant
{
    /**
     * @param SocialUserRepositoryInterface         $userRepository
     * @param RefreshTokenRepositoryInterface $refreshTokenRepository
     */
    public function __construct(
        SocialUserRepositoryInterface $userRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository
    ) {
        parent::__construct($userRepository, $refreshTokenRepository);
    }
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
        $accessToken = $this->getRequestParameter('access_token', $request);

        if (\is_null($accessToken)) {
            throw OAuthServerException::invalidRequest('access_token');
        }

        $provider = $this->getRequestParameter('provider', $request);

        if (\is_null($provider)) {
            throw OAuthServerException::invalidRequest('provider');
        }

        $user = app()->make(SocialUserRepositoryInterface::class)->userByProviderCredentials($provider, $accessToken);
        if ($user instanceof Authenticatable) {
            auth()->setUser($user);
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
