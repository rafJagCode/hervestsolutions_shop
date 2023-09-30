<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductGetter;

class CarouselController extends AbstractController
{
    private $productGetter;
    public function __construct(ProductGetter $productGetter)
    {
        $this->productGetter = $productGetter;
    }
    /**
     * @Route("/carousel/{category}", name="carousel")
     */
    public function carouselNewest($category): Response
    {
		if($category=='newest') $products = $this->productGetter->getNewest();
		else if($category=='bestsellers') $products = $this->productGetter->getBestSellers();
		else $products = $this->productGetter->getPopular();

        return $this->render("components/carousel.twig", [
            "controller_name" => "CarouselController",
            "selected" => $products,
        ]);
    }
}
