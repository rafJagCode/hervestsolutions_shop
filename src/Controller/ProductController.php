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
		$product = $this->productGetter->getProduct($id);
		$relatedProducts = $this->productGetter->getByOptions(['categoryId'=>$product->getCategory(), 'excludedId' => $id]);

		return $this->render("pages/product-full.twig", [
			"controller_name" => "ProductController",
			"product" => $product,
			"relatedProducts" => $relatedProducts,
		]);
	}
}
