<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductsCategoriesGetter;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends AbstractController
{
	private $client;
	private $productsCategoriesGetter;
	public function __construct(
		HttpClientInterface $client,
		ProductsCategoriesGetter $productsCategoriesGetter,
	) {
		$this->client = $client;
		$this->productsCategoriesGetter = $productsCategoriesGetter;
	}

	/**
	 * @Route("/product/{id}", name="product")
	 */
	public function index(
		$id
	): Response {
		$newest = $this->productsCategoriesGetter->getNewest();
		$response = $this->client->request(
			"POST",
			$_ENV["API_URL"] . "getproduct",
			[
				"json" => ["id" => $id],
			]
		);


		if ($response->getStatusCode() === 200) {
			$product = $response->toArray()[0];
			return $this->render("pages/product-full.twig", [
				"controller_name" => "ProductController",
				"product" => $product,
				"selectedFourProducts" => $newest
			]);
		}
	}
	/**
	 * @Route("/search-in-products/{input}", name="search-in-products")
	 */
	public function searchInProducts($input)
	{

		$products = $this->productsCategoriesGetter->getNewest();
		$regex = "/$input/";
		$filtered = array_filter($products, function($product) use($regex){
			return preg_match($regex, $product["name"]);
		});
		return new JsonResponse($filtered);
	}
}
