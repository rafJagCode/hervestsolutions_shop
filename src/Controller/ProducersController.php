<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Producer;

class ProducersController extends AbstractController
{
	private $client;
	private $em;

	public function __construct(HttpClientInterface $client, EntityManagerInterface $entityManager)
	{
		$this->client = $client;
		$this->em = $entityManager;
	}

	/**
	 * @Route("/producers", name="producers")
	 */
	public function index(): Response
	{
		$producers = $this->em->getRepository(Producer::class)->findAll();
		return $this->render("pages/producers.twig", [
			"controller_name" => "ProducersController",
			"producers" => $producers,
		]);
	}
}
