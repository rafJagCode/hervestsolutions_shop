<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\ProductGetter;

class UserProductSearchController extends AbstractController
{
    private $http;
	private $productGetter;

    public function __construct(HttpClientInterface $client, ProductGetter $productGetter)
    {
        $this->http = $client;
		$this->productGetter = $productGetter;
    }
    /**
     * @Route("/user-product-search/{input}", name="user-product-search")
     */
    public function searchProducts($input): Response
    {
      
		$products = $this->productGetter->search($input);
            return $this->render(
                "components/user-product-search-results.twig",
                [
                    "controller_name" => "UserProductSearchController",
                    "searchResults" => $products,
                ]
            );
    }
}
