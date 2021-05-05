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
        return $this->render('components/customer-creator.twig', [
            'controller_name' => 'CustomerController',
        ]);
    }

    /**
     * @Route("/customer-create", name="customer-create")
     */
    public function createCustomer(): Response
    {
        return $this->render('pages/customer-creator.twig', [
            'controller_name' => 'CustomerController',
        ]);
    }

    /**
     * @Route("/customer-edit", name="customer-edit")
     */
    public function editCustomer(): Response
    {
        return $this->render('pages/customer-creator.twig', [
            'controller_name' => 'CustomerController',
        ]);
    }

    /**
     * @Route("/customer-editor/{id}", name="customer-editor")
     */
    public function customerEditor($id): Response
    {
		$user = (object)['id' => 2, 'firstName' => 'Jan', 'lastName' => 'Kowalski', 'address' => 'Miasto 04-322 ul. Wesoła 5', 'telephone' => '653 532 256', 'email' => 'jankow@test.com'];

        return $this->render('pages/customer-editor.twig', [
            'controller_name' => 'CustomerController',
			'user' => $user,
        ]);
    }

    /**
     * @Route("/customer-order-creator/{id}", name="customer-order-creator")
     */
    public function customerOrderCreator($id): Response
    {
		$user = (object)['id' => 2, 'firstName' => 'Jan', 'lastName' => 'Kowalski', 'address' => 'Miasto 04-322 ul. Wesoła 5', 'telephone' => '653 532 256', 'email' => 'jankow@test.com'];

        return $this->render('pages/customer-order-creator.twig', [
            'controller_name' => 'CustomerController',
			'user' => $user,
        ]);
    }

    /**
     * @Route("/customer-search", name="customer-search")
     */
    public function searchCustomer(): Response
    {
		$user = (object)['id' => 2, 'firstName' => 'Jan', 'lastName' => 'Kowalski', 'address' => 'Miasto 04-322 ul. Wesoła 5', 'telephone' => '653 532 256', 'email' => 'jankow@test.com'];
		$users = [];
		for ($i=0; $i < 10; $i++) {
			array_push($users, $user);
		}
        return $this->render('components/customer-search.twig', [
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
		$shortPassword = substr($password, 0, 6);
		return new Response($shortPassword);
	}
}
