<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;
use App\Service\AuthChecker;
use App\Service\CartGetter;

class LoginController extends AbstractController
{
    private $client;
	private $cartGetter;

    public function __construct(HttpClientInterface $client, CartGetter $cartGetter)
    {
        $this->client = $client;
		$this->cartGetter = $cartGetter;
    }

    /**
     * @Route("/account-login", name="account-login")
     */
    public function index(
        Request $request,
        AuthChecker $authChecker,
        CartGetter $cartGetter
    ): Response {
        $cart = $this->cartGetter->getProducts();
        $isUserAuthenticated = $authChecker->isUserAuthenticated($request);
        return $this->render("/pages/account-login.twig", [
            "controller_name" => "LoginController",
            "isUserAuthenticated" => $isUserAuthenticated,
            "cart" => $cart,
        ]);
    }

    /**
     * @Route("/sign-in", name="sign-in")
     */
    public function signIn(Request $request, ): Response
    {
        $cart = $this->cartGetter->getProducts();
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "login_check",
                [
                    "json" => $request->request->all(),
                ]
            );
        } catch (Exception $exception) {
            throw $exception;
        }

        $statusCode = $statusCode = $response->getStatusCode();
        $token = $response->toArray()["token"];
        $message = $this->getStatusCodeMessage($statusCode);

        if ($statusCode === 200) {
            $cookieResponse = $this->render("/pages/account-dashboard.twig", [
                "controller_name" => "LoginController",
                "isUserAuthenticated" => true,
                "cart" => $cart,
            ]);
            $cookieResponse->headers->setCookie(
                new Cookie(
                    "X-AUTH-TOKEN", // cookie name, should be the same as in JWT settings
                    $token, // the cookie value, e.g. the generated JWT token
                    new \DateTime("+1 day"), // the expiration
                    "/", // the path
                    ".redparts.test", // the domain, null means that Symfony will generate it on its own
                    false, // secure, e.g. only via https
                    false, // http only cookie, which is the default so no need to specify
                    false, // raw
                    "lax" // the same-site parameter, can be 'lax' or 'strict'
                )
            );
            return $cookieResponse;
        }

        return $this->render("/pages/account-login.twig", [
            "controller_name" => "LoginController",
            "loginMessage" => $message,
            "isUserAuthenticated" => false,
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {
        try {
            $response = $this->client->request(
                "POST",
                $_ENV["API_URL"] . "register",
                [
                    "json" => $request->request->all(),
                ]
            );
        } catch (Exception $exception) {
            throw $exception;
        }

        $statusCode = $statusCode = $response->getStatusCode();
        $message = $this->getStatusCodeMessage($statusCode);

        if ($statusCode === 200) {
            $email = $request->request->get("email");
            $request->request->set("username", $email);
            $loginResponse = $this->signIn($request);
            return $loginResponse;
        } else {
            return $this->render("/pages/account-login.twig", [
                "controller_name" => "LoginController",
                "registerMessage" => $message,
                "isUserAuthenticated" => false,
            ]);
        }
    }

    public function getStatusCodeMessage(int $statusCode)
    {
        if ($statusCode === 200) {
            $message = "Logged successfully";
        } elseif ($statusCode === 400) {
            $message = "Account already used";
        } elseif ($statusCode === 401) {
            $message = "Provided credentials were invalid";
        } elseif ($statusCode === 500) {
            $message = "Internal server error";
        } else {
            $message = "Something went wrong";
        }
        return $message;
    }
}
