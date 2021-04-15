<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AuthChecker;
use App\Service\CartGetter;

class ContactController extends AbstractController
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
     * @Route("/contact", name="contact")
     */
    public function index(Request $request): Response
    {
        $isUserAuthenticated = $this->authChecker->isUserAuthenticated(
            $request
        );
        $cart = $this->cartGetter->getProducts();
        return $this->render("pages/contact.twig", [
            "controller_name" => "ContactController",
            "isUserAuthenticated" => $isUserAuthenticated,
            "cart" => $cart,
        ]);
    }
}
