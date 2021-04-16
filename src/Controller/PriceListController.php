<?php

namespace App\Controller;

use App\Service\CartGetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductsCategoriesGetter;
use App\Service\AuthChecker;

class PriceListController extends AbstractController
{
    private $productCategoriesGetter;
    private $cartGetter;
    private $authChecker;
    public function __construct(
        AuthChecker $authChecker,
        CartGetter $cartGetter,
        ProductsCategoriesGetter $productCategoriesGetter
    ) {
        $this->productCategoriesGetter = $productCategoriesGetter;
        $this->cartGetter = $cartGetter;
        $this->authChecker = $authChecker;
    }
    /**
     * @Route("/price-list", name="price-list")
     */
    public function index(Request $request): Response
    {
        $products = $this->productCategoriesGetter->getNewest();
        $cart = $this->cartGetter->getProducts();
        $isUserAuthenticated = $this->authChecker->isUserAuthenticated(
            $request
        );
        return $this->render("pages/price-list.twig", [
            "controller_name" => "PriceListController",
            "products" => $products,
            "cart" => $cart,
            "isUserAuthenticated" => $isUserAuthenticated,
        ]);
    }
}
