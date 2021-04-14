<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AuthChecker;
use App\Service\CartGetter;
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
        Request $request,
        AuthChecker $authChecker,
        CartGetter $cartGetter
    ): Response {
        $isUserAuthenticated = $authChecker->isUserAuthenticated($request);
        $cart = $cartGetter->getProducts();
        $newest = $this->productsCategoriesGetter->getNewest();
        $popular = $this->productsCategoriesGetter->getPopular();
        $bestSellers = $this->productsCategoriesGetter->getBestSellers();

        return $this->render("pages/index.twig", [
            "controller_name" => "IndexController",
            "isUserAuthenticated" => $isUserAuthenticated,
            "cart" => $cart,
            "newest" => $newest,
            "popular" => $popular,
            "bestSellers" => $bestSellers,
        ]);
    }
}
