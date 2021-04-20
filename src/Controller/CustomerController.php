<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customer-creator", name="customer-creator")
     */
    public function index(): Response
    {
        return $this->render('pages/customer-creator.twig', [
            'controller_name' => 'CustomerController',
        ]);
    }

    /**
     * @Route("/customer-search", name="customer-search")
     */
    public function searchCustomer(): Response
    {
		$user = (object)['firstName' => 'Jan', 'lastName' => 'Kowalski', 'address' => 'Miasto 04-322 ul. Wesoła 5', 'telephone' => '653 532 256', 'email' => 'jankow@test.com'];
		$users = [];
		for ($i=0; $i < 10; $i++) {
			array_push($users, $user);
		}
        return $this->render('pages/customer-search.twig', [
            'controller_name' => 'CustomerController',
			'users' => $users,
        ]);
    }

	/**
	 * @Route("/generate-password", name="generate-password")
	 */
	public function generatePassword()
	{
		$password = sha1(random_bytes(10));
		return new Response($password);
	}
}
