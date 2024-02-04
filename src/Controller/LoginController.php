<?php

namespace App\Controller;

use Exception;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\CartGetter;
use App\Entity\User;
use App\Entity\Cart;


class LoginController extends AbstractController
{
	private $em;
	private $translator;
	private $cartGetter;

	public function __construct(
		EntityManagerInterface $entityManager,
		TranslatorInterface $translator,
		CartGetter $cartGetter
	) {
		$this->em = $entityManager;
		$this->translator = $translator;
		$this->cartGetter = $cartGetter;
	}


	/**
	 * @Route("/login", name="login")
	 */
	public function login(AuthenticationUtils $authenticationUtils): Response
	{
		$error = $authenticationUtils->getLastAuthenticationError();

		if($error){
			$message = $this->translator->trans($error->getMessage());
			$this->addFlash('error', $message);
		}

		return $this->render("/pages/account-login.twig", [
			"controller_name" => "LoginController",
		]);
	}

	/**
	 * @Route("/sign-in", name="sign-in")
	 */
	public function signIn(Request $request)
	{
		$user = $this->em->getRepository(User::class)->findOneBy(['email' => $request->request->get('email'), 'password' => $request->request->get('password')]);
		if(!is_null($user)){
			$currentCart = $this->cartGetter->getCart();
			$userCart = $user->getCart();
			foreach($currentCart->getCartItem() as $cartItem){
				$userCart->addCartItem($cartItem);
			};
			$this->em->persist($userCart);
			$this->em->flush();
		}

		return $this->redirectToRoute('login', [
			'request' => $request
		], 307);
	}

	/**
	 * @Route("/register", name="register")
	 */
	public function register(Request $request)
	{	
		$user = $this->em->getRepository(User::class)->findOneBy(['email'=>$request->request->get('email')]);
		if(is_null($user)){
			$cart = $this->cartGetter->getCart();
			$user = new User();
			$user->setEmail($request->request->get('email'));
			$user->setPassword($request->request->get('password'));
			$user->setCart($cart);
	
			$this->em->persist($user);
			$this->em->flush();
			
			return $this->redirectToRoute('login', [
				'request' => $request
			], 307);
		}else{
			$this->addFlash('error', 'Podany email jest już przypisany do innego użytkownika. Użyj innego adresu email.');

			return $this->redirectToRoute('login');
		}
	}
}
