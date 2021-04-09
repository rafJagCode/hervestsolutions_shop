<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;
use App\Service\AuthChecker;
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
    public function index(Request $request, AuthChecker $authChecker): Response
    {
        $isUserAuthenticated = $authChecker->isUserAuthenticated($request);
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "cart",
                [
                    "json" => ["user" => 2],
                ]
            );
        } catch (Exception $exception) {
            throw $exception;
        }

        $statusCode = $response->getStatusCode();
        $products = $response->toArray();
        $totalCost = array_reduce($products, function ($sum, $product) {
            $productStackCost =
                $product["product"]["price"] * $product["product"]["quantity"];
            return $sum + $productStackCost;
        });

        $productsWithImgs = array_map(
            function ($product) {
                $productArray = (array) $product;
                $productArray["image"] =
                    "images/parts/part" . $product["product"]["id"] . ".jpg";
                return (object) $productArray;
            },
            $products,
            array_keys($products)
        );

        if ($statusCode === 200) {
            return $this->render("pages/cart.twig", [
                "controller_name" => "CartController",
                "products" => $productsWithImgs,
                "total" => $totalCost,
                "isUserAuthenticated" => $isUserAuthenticated,
            ]);
        }
    }

    /**
     * @Route("/cart-remove-product", name="cart-remove-product")
     */
    public function cartRemoveProduct(
        Request $request,
        AuthChecker $authChecker
    ): Response {
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "cartRemoveProduct",
                [
                    "json" => $request->request->all(),
                ]
            );
        } catch (Exception $exception) {
            throw $exception;
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            return $this->index($request, $authChecker);
        }
    }

    /**
     * @Route("/cart-add-product", name="cart-add-product")
     */
    public function cartAddProduct(
        Request $request,
        AuthChecker $authChecker
    ): Response {
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "cartAddProduct",
                [
                    "json" => $request->request->all(),
                ]
            );
        } catch (Exception $exception) {
            throw $exception;
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            return $this->index($request, $authChecker);
        }
    }
}
