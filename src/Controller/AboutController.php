<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AuthChecker;
use App\Service\CartGetter;

class AboutController extends AbstractController
{
    public function __construct(
        AuthChecker $authChecker,
        CartGetter $cartGetter
    ) {
        $this->authChecker = $authChecker;
        $this->cartGetter = $cartGetter;
    }
    /**
     * @Route("/about", name="about")
     */
    public function index(Request $request): Response
    {
        $cart = $this->cartGetter->getProducts();
        $isUserAuthenticated = $this->authChecker->isUserAuthenticated(
            $request
        );
        return $this->render("pages/about.twig", [
            "controller_name" => "AboutController",
            "isUserAuthenticated" => $isUserAuthenticated,
            "cart" => $cart,
        ]);
    }
}
