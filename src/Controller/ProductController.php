<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AuthChecker;
use Exception;

class ProductController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
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
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "getproducts"
            );
        } catch (Exception $exception) {
            throw $exception;
        }

        $statusCode = $response->getStatusCode();
        $products = $response->toArray();

        $productsWithImgs = array_map(
            function ($product, $key) {
                $productArray = (array) $product;
                $productArray["image"] =
                    "images/parts/part" . $key + 2 . ".jpg";
                return (object) $productArray;
            },
            $products,
            array_keys($products)
        );
        $ids = array_column($productsWithImgs, "id");
        $chosenProductKey = array_search($id, $ids);
        $chosenProduct = $productsWithImgs[$chosenProductKey];

        if ($statusCode === 200) {
            return $this->render("pages/product-full.twig", [
                "controller_name" => "ProductController",
                "product" => $chosenProduct,
                "isUserAuthenticated" => $isUserAuthenticated,
            ]);
        }
    }
}
