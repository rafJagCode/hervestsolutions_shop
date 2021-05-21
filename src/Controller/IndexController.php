<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductGetter;

class IndexController extends AbstractController
{
    private $productGetter;
    public function __construct(ProductGetter $productGetter)
    {
        $this->productGetter = $productGetter;
    }
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $newest = $this->productGetter->getNewest();
        $popular = $this->productGetter->getPopular();
        $bestSellers = $this->productGetter->getBestSellers();

        return $this->render("pages/index.twig", [
            "controller_name" => "IndexController",
            "newest" => $newest,
            "popular" => $popular,
            "bestSellers" => $bestSellers,
        ]);
    }
}
