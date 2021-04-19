<?php

namespace App\Security;

use App\Security\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;
use App\Service\CartGetter;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
	use TargetPathTrait;

	private $LOGIN_ROUTE = 'sign-in';
	private $http;
	private $urlGenerator;
	private $csrfTokenManager;
	private $cartGetter;
	public function __construct(HttpClientInterface $http, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, CartGetter $cartGetter)
	{
		$this->http = $http;
		$this->urlGenerator = $urlGenerator;
		$this->csrfTokenManager = $csrfTokenManager;
		$this->cartGetter = $cartGetter;
	}
	public function supports(Request $request)
	{
		return $this->LOGIN_ROUTE === $request->attributes->get('_route')
			&& $request->isMethod('POST');
		// return false;
		// return $request->cookies->has("X-AUTH-TOKEN");
	}

	public function getCredentials(Request $request)
	{
		$credentials = [
			'username' => $request->request->get('username'),
			'password' => $request->request->get('password'),
			'csrf_token' => $request->request->get('_csrf_token'),
		];
		$request->getSession()->set(
			Security::LAST_USERNAME,
			$credentials['username']
		);

		return $credentials;
	}

	public function getUser($credentials, UserProviderInterface $userProvider)
	{
		// $token = new CsrfToken('authenticate', $credentials['csrf_token']);
		// if (!$this->csrfTokenManager->isTokenValid($token)) {
		// 	throw new InvalidCsrfTokenException();
		// }
		$response = $this->http->request(
			"POST",
			$_ENV["API_URL"] . "login_check",
			[
				"json" => ['username' => $credentials['username'], 'password' => $credentials['password']]
			]
		);
		if (!$response->getStatusCode() === 200) {
			throw new CustomUserMessageAuthenticationException('There is no such user');
		}

		$user = new User();
		$user->setEmail('test@email');
		$user->setRoles(['ADMIN_ROLE']);
		$user->setToken($response->toArray()['token']);
		$user->setCart($this->cartGetter->getProducts());

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

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
	{
		if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
			return new RedirectResponse($targetPath);
		}
		return new RedirectResponse($this->urlGenerator->generate('dashboard'));
		// For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));
		throw new \Exception('TODO: provide a valid redirect inside ' . __FILE__);
	}

	protected function getLoginUrl()
	{
		return $this->urlGenerator->generate($this->LOGIN_ROUTE);
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
