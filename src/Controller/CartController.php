<?php

namespace App\Controller;

use App\Service\CartGetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\ProductGetter;

class CartController extends AbstractController
{
    private $client;
    private $cartGetter;
    private $session;
    private $productGetter;
    public function __construct(
        HttpClientInterface $client,
        CartGetter $cartGetter,
        SessionInterface $session,
        ProductGetter $productGetter
    ) {
        $this->client = $client;
        $this->cartGetter = $cartGetter;
        $this->session = $session;
        $this->productGetter = $productGetter;
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
        $request = json_decode($request->getContent(), true);
        $this->removeProduct($request);

        return new Response("product removed");
    }

    /**
     * @Route("/cart-add-product", name="cart-add-product")
     */
    public function cartAddProduct(Request $request): Response
    {
        $request = json_decode($request->getContent(), true);
        $this->addProduct($request);
        return new Response("product added");
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

    public function isUserAuth()
    {
        if (!$this->getUser()) {
            return false;
        }
        return true;
    }

    public function addProduct($request)
    {
        if ($this->isUserAuth()) {
            return $this->addProductAuth($request);
        }
        return $this->addProductUnauth($request);
    }

    public function removeProduct($request)
    {
        if ($this->isUserAuth()) {
            return $this->removeProductAuth($request);
        }
        return $this->removeProductUnauth($request);
    }

    public function makeAddingRequest($request, $identyfier, $api)
    {
        $response = $this->client->request("POST", $_ENV["API_URL"] . $api, [
            "json" => [
                "quantity" => $request["quantity"],
                "product" => $request["product"],
                "user" => $identyfier,
            ],
        ]);
    }

    public function makeRemovingRequest($request, $api)
    {
        $response = $this->client->request("POST", $_ENV["API_URL"] . $api, [
            "json" => ["id" => $request["id"]],
        ]);
    }

    public function addProductAuth($request)
    {
        $userId = $this->getUser()->getId();
        $this->makeAddingRequest($request, $userId, "cartAddProduct");
        $cart = $this->cartGetter->getCart();
        $this->getUser()->setCart($cart);
        return;
    }

    public function removeProductAuth($request)
    {
        $this->makeRemovingRequest($request, "cartRemoveProduct");
        $cart = $this->cartGetter->getCart();
        $this->getUser()->setCart($cart);
        return;
    }

    public function addProductUnauth($request)
    {
        $UUID = $this->getUUID();
        $this->makeAddingRequest($request, $UUID, "cartAddProduct");
        $cart = $this->cartGetter->getCart();
        $this->session->set("cart", $cart);
        return;
    }

    public function removeProductUnauth($request)
    {
        $this->makeRemovingRequest($request, "cartRemoveProduct");
        $cart = $this->cartGetter->getCart();
        $this->session->set("cart", $cart);
    }

    public function getUUID()
    {
        $UUID = $this->session->get("UUID");
        if (!$UUID) {
            $UUID = $this->uuid();
            $UUID = 3; //test
            $this->session->set("UUID", $UUID);
        }
        return $UUID;
    }

    function uuid()
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
        return vsprintf("%s%s-%s-%s-%s-%s%s%s", str_split(bin2hex($data), 4));
    }
}
