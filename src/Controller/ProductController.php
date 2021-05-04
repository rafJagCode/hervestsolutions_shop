<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductsCategoriesGetter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Exception;

class ProductController extends AbstractController
{
    private $client;
    private $productsCategoriesGetter;
    public function __construct(
        HttpClientInterface $client,
        ProductsCategoriesGetter $productsCategoriesGetter
    ) {
        $this->client = $client;
        $this->productsCategoriesGetter = $productsCategoriesGetter;
    }

    /**
     * @Route("/product/{id}", name="product")
     */
    public function index($id): Response
    {
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
                "selectedFourProducts" => $newest,
            ]);
        }
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
    }
}
