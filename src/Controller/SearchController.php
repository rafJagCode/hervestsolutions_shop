<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductGetter;

class SearchController extends AbstractController
{
	private $productGetter;

    public function __construct(ProductGetter $productGetter)
    {
		$this->productGetter = $productGetter;
    }
	
	/**
	 * @Route("/search-in-products/{phraze}", name="search-in-products")
	 */
	public function searchInProducts($phraze)
	{
		$products = $this->productGetter->getByPhraze($phraze, 5);

		return $this->render(
			"components/search-results.twig", [
				"controller_name" => "SearchController",
				"searchResults" => $products,
			]
		);
	}
}
