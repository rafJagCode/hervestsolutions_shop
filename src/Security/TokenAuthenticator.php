<?php

namespace App\Security;

use App\Security\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\CartGetter;
use App\Service\JwtDecoder;
use Symfony\Component\HttpFoundation\Response;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
	use TargetPathTrait;

	private $LOGIN_ROUTE = "sign-in";
	private $http;
	private $urlGenerator;
	private $csrfTokenManager;
	private $cartGetter;
	private $jwtDecoder;
	private $templating;
	private $flashBag;
	private $security;
	private $userProviderInterface;

	public function __construct(
		HttpClientInterface $http,
		UrlGeneratorInterface $urlGenerator,
		CsrfTokenManagerInterface $csrfTokenManager,
		CartGetter $cartGetter,
		JwtDecoder $jwtDecoder,
		ContainerInterface $container,
		FlashBagInterface $flashBag,
		Security $security,
		UserProviderInterface $userProviderInterface,
	) {
		$this->http = $http;
		$this->urlGenerator = $urlGenerator;
		$this->csrfTokenManager = $csrfTokenManager;
		$this->cartGetter = $cartGetter;
		$this->jwtDecoder = $jwtDecoder;
		$this->templating = $container->get("templating");
		$this->flashBag = $flashBag;
		$this->security = $security;
		$this->userProviderInterface = $userProviderInterface;
	}


	public function supports(Request $request)
	{
		return ($this->LOGIN_ROUTE === $request->attributes->get("_route") &&
			$request->isMethod("POST"));
	}

	public function getCredentials(Request $request)
	{
		$loginData = [
			'username' => $request->request->get('username'),
			'password' => $request->request->get('password'),
		];

		$response = $this->loginThroughApi($loginData);

		if ($response->getStatusCode() !== 200) {
			throw new CustomUserMessageAuthenticationException(
				"Invalid Credentials"
			);
		}

		$request
			->getSession()
			->set(Security::LAST_USERNAME, $loginData['username']);

		return $response->toArray()["token"];
	}
	public function getUser($token, UserProviderInterface $userProvider)
	{

		if ($token=== null) {
			throw new CustomUserMessageAuthenticationException(
				"No Token Recived"
			);
		}


		$userDetails = $this->jwtDecoder->getPayload($token);
		$user = new User();
		$user->setToken($token);
		$user->setEmail($userDetails->username);
		$user->setRoles($userDetails->roles);
		$user->setRoles(['ROLE_ADMIN']);
		$user->setId(3);



		// $user = $this->getNormalUser();
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
		$engine = $this->templating;
		$this->flashBag->add("notice", $exception->getMessage());
		$view = $engine->render("/pages/account-login.twig", [
			"controller_name" => "LoginController",
		]);
		return new Response($view);
	}

	public function onAuthenticationSuccess(
		Request $request,
		TokenInterface $token,
		$providerKey
	) {
		$token->getUser()->setCart($this->cartGetter->getCart());
		if (
			$targetPath = $this->getTargetPath(
				$request->getSession(),
				$providerKey
			)
		) {
			return new RedirectResponse($targetPath);
		}

		return new RedirectResponse($this->urlGenerator->generate("dashboard"));

		throw new \Exception(
			"TODO: provide a valid redirect inside " . __FILE__
		);
	}

	protected function getLoginUrl()
	{
		return $this->urlGenerator->generate($this->LOGIN_ROUTE);
	}

	public function start(
		Request $request,
		AuthenticationException $authException = null
	) {
	}

	public function supportsRememberMe()
	{
		// todo
	}

	public function getNormalUser()
	{
		$user = new User();
		$user->removeAllRoles();
		$user->setRoles(['ROLE_USER']);
		$user->setId(1);
		$user->setEmail('normal-user@test.com');
		$user->setCart($this->cartGetter->getCart());
		return $user;
	}

	public function loginThroughApi($credentials)
	{
		$response = $this->http->request(
			"POST",
			$_ENV["API_URL"] . "login_check",
			[
				"json" => [
					"username" => $credentials["username"],
					"password" => $credentials["password"],
				],
			]
		);
		return $response;
	}
}
