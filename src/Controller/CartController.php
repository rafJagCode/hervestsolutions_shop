<?php

namespace App\Controller;

use App\Service\CartGetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    private $client;
    private $cartGetter;
    public function __construct(
        HttpClientInterface $client,
        CartGetter $cartGetter
    ) {
        $this->client = $client;
        $this->cartGetter = $cartGetter;
    }

    /**
     * @Route("/cart", name="cart")
     */
    public function getCart(): Response
    {
        $cart = $this->cartGetter->getCart();

        $totalCost = array_reduce($cart, function ($sum, $product) {
            $productStackCost =
                $product["product"]["price"] * $product["product"]["quantity"];
            return $sum + $productStackCost;
        });

        return $this->render("pages/cart.twig", [
            "controller_name" => "CartController",
            "products" => $cart,
            "total" => $totalCost,
            "cart" => $cart,
        ]);
    }

    /**
     * @Route("/cart-remove-product", name="cart-remove-product")
     */
    public function cartRemoveProduct(Request $request): Response
    {
        $user = $this->getUser();
        $axiosRequest = json_decode($request->getContent(), true);
        $response = $this->client->request(
            "POST",
            $_ENV["API_URL"] . "cartRemoveProduct",
            [
                "json" => ["id" => $axiosRequest["id"]],
            ]
        );

        $cart = $this->cartGetter->getCart();

        if ($response->getStatusCode() === 200) {
            $user->setCart($cart);
            return new Response("product removed");
        }
    }

    /**
     * @Route("/cart-add-product", name="cart-add-product")
     */
    public function cartAddProduct(Request $request): Response
    {
        $user = $this->getUser();

        $axiosRequest = json_decode($request->getContent(), true);

        $response = $this->client->request(
            "POST",
            $_ENV["API_URL"] . "cartAddProduct",
            [
                "json" => [
                    "quantity" => $axiosRequest["quantity"],
                    "product" => $axiosRequest["product"],
                    "user" => $user->getId(),
                ],
            ]
        );

        $cart = $this->cartGetter->getCart();

        if ($response->getStatusCode() === 200) {
            $user->setCart($cart);
            return new Response("product added");
        }
    }

    /**
     * @Route("/cart-items", name="cart-items")
     */
    public function cartItems()
    {
        $cart = $this->cartGetter->getCart();

        return $this->render("components/cart-items.twig", [
            "controller_name" => "CartController",
            "cartItems" => $cart,
        ]);
    }

    /**
     * @Route("/cart-dropdown-items", name="cart-dropdown-items")
     */
    public function cartDropdownItems()
    {
        $cart = $this->cartGetter->getCart();

        return $this->render("components/cart-dropdown-items.twig", [
            "controller_name" => "CartController",
            "cart" => $cart,
        ]);
    }
}
