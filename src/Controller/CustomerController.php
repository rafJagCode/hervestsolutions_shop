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
	 * @Route("/generate-password", name="generate-password")
	 */
	public function generatePassword()
	{
		$password = sha1(random_bytes(10));
		return new Response($password);
	}
}
