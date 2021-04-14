<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AuthChecker;
use App\Service\CartGetter;
use App\Service\ProductsCategoriesGetter;
use Exception;

class ProductController extends AbstractController
{
    private $client;
    private $cartGetter;
	private $productsCategoriesGetter;
    public function __construct(
        HttpClientInterface $client,
        CartGetter $cartGetter,
		ProductsCategoriesGetter $productsCategoriesGetter,
    ) {
        $this->client = $client;
        $this->cartGetter = $cartGetter;
		$this->productsCategoriesGetter = $productsCategoriesGetter;
    }

    /**
     * @Route("/product/{id}", name="product")
     */
    public function index(
        Request $request,
        AuthChecker $authChecker,
        $id
    ): Response {
        $isUserAuthenticated = $authChecker->isUserAuthenticated($request);
        $cart = $this->cartGetter->getProducts();
		$newest = $this->productsCategoriesGetter->getNewest();
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "getproduct",
                [
                    "json" => ["id" => $id],
                ]
            );
        } catch (Exception $exception) {
            throw $exception;
        }

        $statusCode = $response->getStatusCode();
        $product = $response->toArray()[0];

        if ($statusCode === 200) {
            return $this->render("pages/product-full.twig", [
                "controller_name" => "ProductController",
                "product" => $product,
                "isUserAuthenticated" => $isUserAuthenticated,
                "cart" => $cart,
				"selectedFourProducts" => $newest
            ]);
        }
    }
}
