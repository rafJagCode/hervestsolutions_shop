<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
	private $client;
	public function __construct(HttpClientInterface $client)
	{
		$this->client = $client;
	}

	/**
	 * @Route("/cart", name="cart")
	 */
	public function index(): Response
	{
		$response = $this->client->request(
			"POST",
			$_ENV["API_URL"] . "cart",
			[
				"json" => ["user" => 2],
			]
		);


		if ($response->getStatusCode() === 200) {
			$products = $response->toArray();
			$totalCost = array_reduce($products, function ($sum, $product) {
				$productStackCost =
					$product["product"]["price"] * $product["product"]["quantity"];
				return $sum + $productStackCost;
			});
			return $this->render("pages/cart.twig", [
				"controller_name" => "CartController",
				"products" => $products,
				"total" => $totalCost,
				"cart" => $products,
			]);
		}
	}

	/**
	 * @Route("/cart-remove-product", name="cart-remove-product")
	 */
	public function cartRemoveProduct(
		Request $request
	): Response {
		$response = $this->client->request(
			"POST",
			$_ENV["API_URL"] . "cartRemoveProduct",
			[
				"json" => $request->request->all(),
			]
		);


		if ($response->getStatusCode() === 200) {
			return $this->index();
		}
	}

	/**
	 * @Route("/cart-add-product", name="cart-add-product")
	 */
	public function cartAddProduct(
		Request $request
	): Response {
		$response = $this->client->request(
			"POST",
			$_ENV["API_URL"] . "cartAddProduct",
			[
				"json" => $request->request->all(),
			]
		);

		if ($response->getStatusCode() === 200) {
			return $this->index();
		}
	}

	/**
	 * @Route("/cart-items", name="cart-items")
	 */
	public function cartItems()
	{
		$response = $this->client->request(
			"POST",
			$_ENV["API_URL"] . "cart",
			[
				"json" => ["user" => 2],
			]
		);

		if ($response->getStatusCode() === 200) {
			$products = $response->toArray();
			return $this->render("components/cart-items.twig", [
				"controller_name" => "CartController",
				"cartItems" => $products,
			]);
		}
	}

	/**
	 * @Route("/cart-dropdown-items", name="cart-dropdown-items")
	 */
	public function cartDropdownItems()
	{
		$response = $this->client->request(
			"POST",
			$_ENV["API_URL"] . "cart",
			[
				"json" => ["user" => 2],
			]
		);

		if ($response->getStatusCode() === 200) {
			$products = $response->toArray();
			return $this->render("components/cart-dropdown-items.twig", [
				"controller_name" => "CartController",
				"cart" => $products,
			]);
		}
	}
}
