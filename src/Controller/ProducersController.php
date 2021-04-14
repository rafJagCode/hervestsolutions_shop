<?php

namespace App\Controller;

use App\Service\AuthChecker;
use App\Service\CartGetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;

class ProducersController extends AbstractController
{
    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/producers", name="producers")
     */
    public function index(
        Request $request,
        AuthChecker $authChecker,
        CartGetter $cartGetter
    ): Response {
        $cart = $cartGetter->getProducts();
        $isUserAuthenticated = $authChecker->isUserAuthenticated($request);
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "manufacturers"
            );
        } catch (Exception $exception) {
            throw $exception;
        }

        $statusCode = $response->getStatusCode();
        $producers = $response->toArray();

        if ($statusCode === 200) {
            return $this->render("pages/producers.twig", [
                "controller_name" => "ProducersController",
                "isUserAuthenticated" => $isUserAuthenticated,
                "producers" => $producers,
                "cart" => $cart,
            ]);
        }
    }
}
