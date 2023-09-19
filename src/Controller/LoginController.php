<?php

namespace App\Controller;

use Exception;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Cart;


class LoginController extends AbstractController
{
	private $client;
	private $em;

	public function __construct(
		HttpClientInterface $client,
		EntityManagerInterface $entityManager
	) {
		$this->client = $client;
		$this->em = $entityManager;
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
	public function signIn(AuthenticationUtils $authenticationUtils): Response
	{

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

		return $this->render("/pages/account-login.twig", [
			"controller_name" => "LoginController",
			"error"=>$error,
		]);
	}

	/**
	 * @Route("/register", name="register")
	 */
	public function register(Request $request)
	{
		$cart = new Cart();
		$this->em->persist($cart);

		$user = new User();
		$user->setEmail($request->request->get('email'));
		$user->setPassword($request->request->get('password'));
		$user->setCart($cart);

		$this->em->persist($user);
        $this->em->flush();

		return $this->redirectToRoute('sign-in');
	}
}
