<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProducersController extends AbstractController
{

	public function __construct()
	{
	}

	/**
	 * @Route("/producers", name="producers")
	 */
	public function index(): Response
	{
		return $this->render("pages/producers.twig", [
			"controller_name" => "ProducersController",
		]);
	}
}
