<?php
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;

class ProductsCategoriesGetter
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getNewest()
    {
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "getproducts"
            );
        } catch (Exception $exception) {
            throw $exception;
        }
        $products = $response->toArray();

        return $products;
    }

    public function getPopular()
    {
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "getproducts"
            );
        } catch (Exception $exception) {
            throw $exception;
        }
        $products = $response->toArray();

        return $products;
    }

    public function getBestSellers()
    {
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "getproducts"
            );
        } catch (Exception $exception) {
            throw $exception;
        }
        $products = $response->toArray();

        return $products;
    }
}
?>
