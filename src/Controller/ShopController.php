<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ShopController extends AbstractController
{
	private $client;
	public function __construct(HttpClientInterface $client)
	{
		$this->client = $client;
	}

	/**
	 * @Route("/shop", name="shop")
	 */
	public function index(): Response
	{
		$response = $this->client->request(
			"POST",
			$_ENV["API_URL"] . "getproducts"
		);


		if ($response->getStatusCode() === 200) {
			$products = $response->toArray();
			return $this->render("pages/shop-grid-4-columns-full.twig", [
				"controller_name" => "ShopController",
				"products" => $products,
			]);
		}
	}
}
