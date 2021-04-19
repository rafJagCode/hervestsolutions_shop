<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductsCategoriesGetter;

class IndexController extends AbstractController
{
    private $productsCategoriesGetter;
    public function __construct(
        ProductsCategoriesGetter $productsCategoriesGetter
    ) {
        $this->productsCategoriesGetter = $productsCategoriesGetter;
    }
    /**
     * @Route("/", name="index")
     */
    public function index(
    ): Response {
        $newest = $this->productsCategoriesGetter->getNewest();
        $popular = $this->productsCategoriesGetter->getPopular();
        $bestSellers = $this->productsCategoriesGetter->getBestSellers();

        return $this->render("pages/index.twig", [
            "controller_name" => "IndexController",
            "newest" => $newest,
            "popular" => $popular,
            "bestSellers" => $bestSellers,
        ]);
    }
}
