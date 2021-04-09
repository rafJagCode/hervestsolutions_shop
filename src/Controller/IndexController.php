<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AuthChecker;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, AuthChecker $authChecker): Response
    {
        $isUserAuthenticated = $authChecker->isUserAuthenticated($request);

        return $this->render("pages/index.twig", [
            "controller_name" => "IndexController",
            "isUserAuthenticated" => $isUserAuthenticated,
        ]);
    }
}
