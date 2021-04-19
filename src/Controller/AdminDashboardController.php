<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
	/**
	 * @Route("/admin-dashboard", name="admin-dashboard")
	 */
	public function index(): Response
	{
		return $this->render("pages/admin-dashboard.twig", [
			"controller_name" => "AdminDashboardController",
		]);
	}
}
