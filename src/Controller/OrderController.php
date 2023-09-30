<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public function __construct()
    {

    }
    /**
     * @Route("/checkout", name="checkout")
     */
    public function checkout(): Response
    {
        return $this->render("pages/checkout.twig", [
            "controller_name" => "OrderController",
        ]);
    }

	/**
     * @Route("/order-success", name="order-success")
     */
    public function orderSuccess(): Response
    {
        return $this->render("pages/order-success.twig", [
            "controller_name" => "OrderController",
        ]);
    }
}
