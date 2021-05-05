<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserProductSearchController extends AbstractController
{
    private $http;
    public function __construct(HttpClientInterface $client)
    {
        $this->http = $client;
    }
    /**
     * @Route("/user-product-search/{input}", name="user-product-search")
     */
    public function searchProducts($input): Response
    {
        $response = $this->http->request(
            "POST",
            "http://redparts.test/search-in-products",
            [
                "json" => ["number" => $input],
            ]
        );
        if ($response->getStatusCode() === 200) {
            $products = $response->toArray();

            return $this->render(
                "components/user-product-search-results.twig",
                [
                    "controller_name" => "UserProductSearchController",
                    "searchResults" => $products,
                ]
            );
        }
        if ($response->getStatusCode() === 404) {
            return $this->render(
                "components/user-product-search-results.twig",
                [
                    "controller_name" => "UserProductSearchController",
                    "searchResults" => [],
                ]
            );
        }
    }
}
