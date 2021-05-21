<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\ProductGetter;

class ShopController extends AbstractController
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
     * @Route("/shop", name="shop")
     */
    public function index(): Response
    {
        $products = $this->productGetter->getProducts();
        return $this->render("pages/shop-grid-4-columns-full.twig", [
            "controller_name" => "ShopController",
            "products" => $products,
        ]);
    }

    /**
     * @Route("/shop/{brand}", name="shop-by-brand")
     */
    public function getProductsByBrand($brand)
    {
        $products = $this->productGetter->getProductsByBrand($brand);
        return $this->render("pages/shop-grid-4-columns-full.twig", [
            "controller_name" => "ShopController",
            "products" => $products,
        ]);
    }
}
