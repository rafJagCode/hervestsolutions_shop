<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AuthChecker;
use App\Service\CartGetter;

class AdminDashboardController extends AbstractController
{
    private $authChecker;
    private $cartGetter;

    public function __construct(
        AuthChecker $authChecker,
        CartGetter $cartGetter
    ) {
        $this->authChecker = $authChecker;
        $this->cartGetter = $cartGetter;
    }
    /**
     * @Route("/admin-dashboard", name="admin-dashboard")
     */
    public function index(Request $request): Response
    {
        $isUserAuthenticated = $this->authChecker->isUserAuthenticated(
            $request
        );
        $cart = $this->cartGetter->getProducts();
        return $this->render("pages/admin-dashboard.twig", [
            "controller_name" => "AdminDashboardController",
            "cart" => $cart,
            "isUserAuthenticated" => $isUserAuthenticated,
        ]);
    }
}
