<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductsCategoriesGetter;

class CarouselController extends AbstractController
{
    private $productsCategoriesGetter;
    public function __construct(
        ProductsCategoriesGetter $productsCategoriesGetter
    ) {
        $this->productsCategoriesGetter = $productsCategoriesGetter;
    }
    /**
     * @Route("/carousel-newest", name="carousel")
     */
    public function index(): Response
    {
        $newest = $this->productsCategoriesGetter->getNewest();
        return $this->render("components/carousel.twig", [
            "controller_name" => "CarouselController",
            "selected" => $newest,
        ]);
    }
}
