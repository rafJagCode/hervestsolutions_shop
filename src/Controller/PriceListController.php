<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductsCategoriesGetter;

class PriceListController extends AbstractController
{
	private $productCategoriesGetter;
	public function __construct(
		ProductsCategoriesGetter $productCategoriesGetter
	) {
		$this->productCategoriesGetter = $productCategoriesGetter;
	}

	/**
	 * @Route("/price-list", name="price-list")
	 */
	public function index(): Response
	{
		$products = $this->productCategoriesGetter->getNewest();
		return $this->render("pages/price-list.twig", [
			"controller_name" => "PriceListController",
			"products" => $products,
		]);
	}
}
