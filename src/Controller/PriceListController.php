<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductGetter;

class PriceListController extends AbstractController
{
    private $productGetter;
    public function __construct(ProductGetter $productGetter)
    {
        $this->productGetter = $productGetter;
    }

    /**
     * @Route("/price-list", name="price-list")
     */
    public function index(): Response
    {
        $products = $this->productGetter->getNewest();
        return $this->render("pages/price-list.twig", [
            "controller_name" => "PriceListController",
            "products" => $products,
        ]);
    }
}
