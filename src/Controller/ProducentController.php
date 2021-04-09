<?php

namespace App\Controller;

use App\Service\AuthChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProducentController extends AbstractController
{
    public function getProducer($name, $image)
    {
        $producer = (object) [
            "name" => $name,
            "image" => $image,
        ];
        return $producer;
    }
    /**
     * @Route("/producers", name="producers")
     */
    public function index(Request $request, AuthChecker $authChecker): Response
    {
        $producers = [
            $this->getProducer("AGCO", "images/producers/agco.png"),
            $this->getProducer("Arbos", "images/producers/arbos.png"),
            $this->getProducer("Case", "images/producers/case.png"),
            $this->getProducer("Cat", "images/producers/cat.png"),
            $this->getProducer("Claas", "images/producers/claas.png"),
            $this->getProducer("Krone", "images/producers/krone.png"),
            $this->getProducer(
                "Massey Ferguson",
                "images/producers/massey_ferguson.png"
            ),
        ];

        $isUserAuthenticated = $authChecker->isUserAuthenticated($request);
        return $this->render("pages/producers.twig", [
            "controller_name" => "ProducentController",
            "isUserAuthenticated" => $isUserAuthenticated,
            "producers" => $producers,
        ]);
    }
}
