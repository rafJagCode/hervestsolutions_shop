<?php

namespace App\Controller;

use Exception;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class LoginController extends AbstractController
{
	private $client;

	public function __construct(
		HttpClientInterface $client,
	) {
		$this->client = $client;
	}

	/**
	 * @Route("/account-login", name="account-login")
	 */
	public function index(): Response
	{
		return $this->render("/pages/account-login.twig", [
			"controller_name" => "LoginController",
		]);
	}
	/**
	 * @Route("/logout", name="logout")
	 */
	public function logout()
	{
		return $this->redirectToRoute('index');
	}

	/**
	 * @Route("/sign-in", name="sign-in")
	 */
	public function signIn(): Response
	{
		return $this->render("/pages/account-login.twig", [
			"controller_name" => "LoginController",
		]);
	}

	/**
	 * @Route("/register", name="register")
	 */
	public function register(Request $request, AuthenticationUtils $authenticationUtils)
	{
		$response = $this->client->request(
			"POST",
			$_ENV["API_URL"] . "register",
			[
				"json" => $request->request->all(),
			]
		);

		if ($response->getStatusCode() === 200) {
			$email = $request->request->get("email");
			$request->request->set("username", $email);
			$loginResponse = $this->signIn($authenticationUtils);
			return $loginResponse;
		}

		return $this->render("/pages/account-login.twig", [
			"controller_name" => "LoginController",
			"registerMessage" => $response->getStatusCode(),
		]);
	}
}
