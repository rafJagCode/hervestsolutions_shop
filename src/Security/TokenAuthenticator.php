<?php

namespace App\Security;

use App\Security\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    public function supports(Request $request)
    {
        return false;
        // return $request->cookies->has("X-AUTH-TOKEN");
    }

    public function getCredentials(Request $request)
    {
        $credentials = "test";
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (null === $credentials) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"

            return null;
        }
        $user = new User();
        $user->setEmail("email-testowy");
        // The "username" in this case is the apiToken, see the key `property`
        // of `your_db_provider` in `security.yaml`.
        // If this returns a user, checkCredentials() is called next:
        // return $userProvider->loadUserByUsername($credentials);
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ) {
        return null;
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        $providerKey
    ) {
        return null;
    }

    public function start(
        Request $request,
        AuthenticationException $authException = null
    ) {
        // todo
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
