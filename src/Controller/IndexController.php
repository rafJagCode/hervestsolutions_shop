<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AuthChecker;
use App\Service\CartGetter;

class IndexController extends AbstractController
{
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

        return $this->render("pages/index.twig", [
            "controller_name" => "IndexController",
            "isUserAuthenticated" => $isUserAuthenticated,
            "cart" => $cart,
        ]);
    }
}
