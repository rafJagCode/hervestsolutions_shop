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
     * @Route("/carousel-newest", name="carousel")
     */
    public function index(): Response
    {
        $newest = $this->productGetter->getNewest();
        return $this->render("components/carousel.twig", [
            "controller_name" => "CarouselController",
            "selected" => $newest,
        ]);
    }
}
