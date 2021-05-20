<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductsCategoriesGetter;

class ProductEditionController extends AbstractController
{
	private $productsCategoriesGetter;
	public function __construct(ProductsCategoriesGetter $productsCategoriesGetter)
	{
		$this->productsCategoriesGetter = $productsCategoriesGetter;
	}

    /**
     * @Route("/product/{id}/edition", name="product_edition")
     */
    public function index(): Response
    {
		$product = $this->productsCategoriesGetter->getNewest()[0];
        return $this->render('pages/product-edition.twig', [
            'controller_name' => 'ProductEditionController',
			'product' => $product
        ]);
    }

    /**
     * @Route("/edit-product", name="edit-product")
     */
	public function edit(Request $request)
	{
		$data = json_decode($request->getContent());
		dd($data);
	}
}
