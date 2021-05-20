<?php
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Exception;

class CartGetter
{
    private $client;
    private $tokenStorage;

    public function __construct(
        HttpClientInterface $client,
        TokenStorageInterface $tokenStorageInterface
    ) {
        $this->client = $client;
        $this->tokenStorage = $tokenStorageInterface;
    }

    public function getCart()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if (!$user) {
            return [];
        }
        $cart = $this->getAuthenticatedUserCart($user->getId());
        $user->setCart($cart);

        return $cart;
    }

    public function getAuthenticatedUserCart($userId)
    {
        $response = $this->client->request("POST", $_ENV["API_URL"] . "cart", [
            "json" => ["user" => $userId],
        ]);
        $products = $response->toArray();

        return $products;
    }
}
?>
