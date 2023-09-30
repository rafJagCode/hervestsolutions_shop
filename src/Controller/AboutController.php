<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * @Route("/about", name="about")
     */
    public function index(): Response
    {
        return $this->render("pages/about.twig", [
            "controller_name" => "AboutController",
        ]);
    }
}
