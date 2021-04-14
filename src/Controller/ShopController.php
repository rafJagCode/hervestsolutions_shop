<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;
use App\Service\AuthChecker;
use App\Service\CartGetter;
use Symfony\Component\HttpFoundation\Request;

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
    public function index(
        Request $request,
        AuthChecker $authChecker,
        CartGetter $cartGetter
    ): Response {
        $cart = $cartGetter->getProducts();
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

        if ($statusCode === 200) {
            return $this->render("pages/shop-grid-4-columns-full.twig", [
                "controller_name" => "ShopController",
                "productsB" => $products,
                "isUserAuthenticated" => $isUserAuthenticated,
                "cart" => $cart,
            ]);
        }
    }
}
