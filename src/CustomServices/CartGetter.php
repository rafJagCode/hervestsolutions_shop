<?php
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Exception;

class CartGetter
{
    private $client;
    private $security;
    private $session;

    public function __construct(
        HttpClientInterface $client,
        Security $security,
        SessionInterface $sessionInterface
    ) {
        $this->client = $client;
        $this->security = $security;
        $this->session = $sessionInterface;
    }

    public function getCart()
    {
        $user = $this->security->getUser();

        if (!$user) {
            return $this->getUnathenticatedUserCart();
        }
        $cart = $this->getAuthenticatedUserCart();
        $user->setCart($cart);

        return $cart;
    }

    public function getCartRequest($identyfier, $api)
    {
        $response = $this->client->request("POST", $_ENV["API_URL"] . $api, [
            "json" => ["user" => $identyfier],
        ]);
        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception("getCartRequest");
        }
        $products = $response->toArray();

        return $products;
    }

    public function getAuthenticatedUserCart()
    {
        $userId = $this->security->getUser()->getId();
        $cart = $this->getCartRequest($userId, "cart");
        return $cart;
    }

    public function getUnathenticatedUserCart()
    {
        $UUID = $this->session->get("UUID");
        if (!$UUID) {
            return [];
        }
        $cart = $this->getCartRequest($UUID, "cart");
        return $cart;
    }
}
?>
