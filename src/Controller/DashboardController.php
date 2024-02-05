<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;

class DashboardController extends AbstractController
{
	private $security;
	private $em;

	public function __construct(Security $security, EntityManagerInterface $entityManager){
		$this->security = $security;
		$this->em = $entityManager;
	}

	/**
	 * @Route("/account-dashboard", name="account-dashboard")
	 */
	public function dashboard(): Response
	{
		$userId = $this->security->getUser()->getId();
		$lastOrders = $this->em->getRepository(Order::class)->findUserOrders($userId, 3);
		
		return $this->render("pages/account-dashboard.twig", [
			"controller_name" => "DashboardController",
			"lastOrders" => $lastOrders
		]);
	}

	/**
     * @Route("/account-profile", name="account-profile")
     */
    public function profile(): Response
    {
        return $this->render('pages/account-profile.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

	/**
     * @Route("/account-submit-profile", name="account-submit-profile")
     */
    public function submitProfile(Request $request): Response
    {
		$user = $this->security->getUser();
		$user->setFirstName($request->request->get('firstName'));
		$user->setLastName($request->request->get('lastName'));
		$user->setPhone($request->request->get('phone'));
		$this->em->persist($user);
		$this->em->flush();

		$this->addFlash('success', 'Dane zostały zaktualizone');

      	return $this->redirectToRoute('account-profile');
    }

	/**
     * @Route("/account-orders", name="account-orders")
     */
    public function orders(): Response
    {
		$userId = $this->security->getUser()->getId();
		$orders = $this->em->getRepository(Order::class)->findUserOrders($userId);

        return $this->render('pages/account-orders.twig', [
            'controller_name' => 'DashboardController',
			'orders' => $orders
        ]);
    }

	/**
     * @Route("/account-password", name="account-password")
     */
    public function password(): Response
    {
        return $this->render('pages/account-password.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

	/**
     * @Route("/account-submit-password", name="account-submit-password")
     */
    public function submitPassword(Request $request): Response
    {
		$user = $this->security->getUser();
		if($request->request->get('currentPassword') !== $user->getPassword()) {
			$this->addFlash('error', 'Podano nieprawidłowe hasło');
			return $this->redirectToRoute('account-password');
		}

		$user->setPassword($request->request->get('newPassword'));
		$this->em->persist($user);
		$this->em->flush();

		$this->addFlash('success', 'Dane zostały zaktualizone');

      	return $this->redirectToRoute('account-password');
    }

	/**
     * @Route("/account-edit-address", name="account-edit-address")
     */
    public function address(): Response
    {
        return $this->render('pages/account-edit-address.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

	/**
     * @Route("/account-submit-address", name="account-submit-address")
     */
    public function submitAddress(Request $request): Response
    {
		$user = $this->security->getUser();
		$user->setCountry($request->request->get('country'));
		$user->setCity($request->request->get('city'));
		$user->setStreet($request->request->get('street'));
		$this->em->persist($user);
		$this->em->flush();

		$this->addFlash('success', 'Dane zostały zaktualizone');

      	return $this->redirectToRoute('account-edit-address');
    }
}
