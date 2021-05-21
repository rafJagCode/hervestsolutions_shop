<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductGetter;

class ProductEditionController extends AbstractController
{
    private $productGetter;
    public function __construct(ProductGetter $productGetter)
    {
        $this->productGetter = $productGetter;
    }

    /**
     * @Route("/product/{id}/edition", name="product_edition")
     */
    public function index(): Response
    {
        $product = $this->productGetter->getNewest()[0];
        return $this->render("pages/product-edition.twig", [
            "controller_name" => "ProductEditionController",
            "product" => $product,
        ]);
    }

    /**
     * @Route("/edit-product", name="edit-product")
     */
    public function edit(Request $request)
    {
        $data = json_decode($request->getContent());
        dd($data);
    }
}
