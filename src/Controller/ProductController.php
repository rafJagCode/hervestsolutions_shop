<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductGetter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Exception;

class ProductController extends AbstractController
{
	private $client;
	private $productGetter;
	public function __construct(
		HttpClientInterface $client,
		ProductGetter $productGetter
	) {
		$this->client = $client;
		$this->productGetter = $productGetter;
	}

	/**
	 * @Route("/product/{id}", name="product")
	 */
	public function index($id): Response
	{
		$newest = $this->productGetter->getNewest();
		$product = $this->productGetter->getProduct($id);

		return $this->render("pages/product-full.twig", [
			"controller_name" => "ProductController",
			"product" => $product,
			"selectedFourProducts" => $newest,
		]);
	}
	/**
	 * @Route("/search-in-products", name="search-in-products")
	 */
	public function searchInProducts(Request $request)
	{
		$requestContent = json_decode($request->getContent(), true);

		$response = $this->client->request(
			"POST",
			$_ENV["API_URL"] . "getproductbynumber",
			[
				"json" => ["number" => $requestContent["number"]],
			]
		);

		if ($response->getStatusCode() === 200) {
			try {
				$products = $response->toArray();
			} catch (Exception) {
				$products = [];
			}
			return new JsonResponse($products);
		}
		if ($response->getStatusCode() === 404) {
			return new JsonResponse([]);
		}
	}
}
