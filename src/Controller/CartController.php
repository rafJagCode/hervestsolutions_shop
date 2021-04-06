<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;

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

        if ($statusCode === 200) {
            return $this->render("pages/cart.twig", [
                "controller_name" => "CartController",
                "products" => $products,
                "total" => $totalCost,
            ]);
        }
    }
}
