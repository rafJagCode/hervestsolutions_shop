<?php
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Exception;

class ProductGetter
{
    private $client;
    private $flash;

    public function __construct(
        HttpClientInterface $client,
        FlashBagInterface $flash
    ) {
        $this->client = $client;
        $this->flash = $flash;
    }

    public function getProduct($id)
    {
        $response = $this->client->request(
            "POST",
            $_ENV["API_URL"] . "getproduct",
            [
                "json" => ["id" => $id],
            ]
        );

        $product = $response->toArray()[0];
        return $product;
    }

    public function getProducts()
    {
        $response = $this->client->request(
            "POST",
            $_ENV["API_URL"] . "getproducts"
        );
        $products = $response->toArray();
        return $products;
    }

    public function getProductsByBrand($brand)
    {
        $response = $this->client->request(
            "POST",
            $_ENV["API_URL"] . "productsbymanufacturername",
            [
                "json" => ["name" => $brand],
            ]
        );
        try {
            $products = $response->toArray();
        } catch (\Exception $exception) {
            $this->flash->add("notice", "error");
            $products = [];
        }
        return $products;
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
