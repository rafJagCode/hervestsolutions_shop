<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class LoginController extends AbstractController
{
	private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/account-login", name="account-login")
     */
    public function index(): Response
    {
        return $this->render('/pages/account-login.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    /**
     * @Route("/sign-in", name="sign-in")
     */
	public function signIn(Request $request): Response
	{
		dump($request);
		exit;
		return $this->render('/pages/account-login.twig', [
            'controller_name' => 'LoginController',
        ]);
	}
}
