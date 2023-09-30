<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductGetter;

class QuickviewController extends AbstractController
{
	private $productGetter;

	public function __construct(ProductGetter $productGetter)
	{
		$this->productGetter = $productGetter;
	}

	/**
	 * @Route("/quickview/{id}", name="quickview")
	 */
	public function index($id): Response
	{
		$product = $this->productGetter->getProduct($id);

		return $this->render("pages/quickview.twig", [
			"controller_name" => "QuickviewController",
			"product" => $product,
		]);
	}
}
