<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AuthChecker;
use App\Service\CartGetter;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(
        Request $request,
        AuthChecker $authChecker,
        CartGetter $cartGetter
    ): Response {
        $cart = $cartGetter->getProducts();
        $isUserAuthenticated = $authChecker->isUserAuthenticated($request);
        $role = $authChecker->getRole($request);
        if ($isUserAuthenticated) {
            return $this->render("pages/account-dashboard.twig", [
                "controller_name" => "DashboardController",
                "isUserAuthenticated" => $isUserAuthenticated,
                "cart" => $cart,
            ]);
        }

        return $this->render("pages/account-login.twig", [
            "controller_name" => "DashboardController",
            "isUserAuthenticated" => $isUserAuthenticated,
            "cart" => $cart,
        ]);
    }
}
