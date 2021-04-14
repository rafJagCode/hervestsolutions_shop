<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;

class QuickviewController extends AbstractController
{
    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/quickview/{id}", name="quickview")
     */
    public function index($id): Response
    {
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "getproduct",
                [
                    "json" => ["id" => $id],
                ]
            );
        } catch (Exception $exception) {
            throw $exception;
        }

        $statusCode = $response->getStatusCode();
        $product = $response->toArray();

        return $this->render("pages/quickview.twig", [
            "controller_name" => "QuickviewController",
            "product" => (object) $product[0],
        ]);
    }
}
