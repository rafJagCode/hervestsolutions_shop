<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProducersController extends AbstractController
{
	private $client;
	public function __construct(HttpClientInterface $client)
	{
		$this->client = $client;
	}

	/**
	 * @Route("/producers", name="producers")
	 */
	public function index(): Response
	{
		$response = $this->client->request(
			"POST",
			$_ENV["API_URL"] . "manufacturers"
		);


		if ($response->getStatusCode() === 200) {
			$producers = $response->toArray();
			return $this->render("pages/producers.twig", [
				"controller_name" => "ProducersController",
				"producers" => $producers,
			]);
		}
	}
}
