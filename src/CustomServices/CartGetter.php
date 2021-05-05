<?php
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;

class CartGetter
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getProducts($user)
    {
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "cart",
                [
                    "json" => ["user" => $user],
                ]
            );
        } catch (Exception $exception) {
            throw $exception;
        }
        $products = $response->toArray();

        return $products;
    }
}
?>
