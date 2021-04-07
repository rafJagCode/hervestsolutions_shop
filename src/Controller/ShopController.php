<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;
use App\Service\AuthChecker;
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
    public function index(Request $request, AuthChecker $authChecker): Response
    {
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

        if ($statusCode === 200) {
            return $this->render("pages/shop-grid-4-columns-full.twig", [
                "controller_name" => "ShopController",
                "productsB" => $productsWithImgs,
                "isUserAuthenticated" => $isUserAuthenticated,
            ]);
        }
    }
}
