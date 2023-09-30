<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Utils\Paginator;
use App\Service\ProductGetter;
use App\Entity\Category;
use App\Entity\Producer;

class ShopController extends AbstractController
{
    private $productGetter;
	private $paginator;
	private $em;

    public function __construct(
        ProductGetter $productGetter,
		EntityManagerInterface $entityManager,
		Paginator $paginator
    ) {
        $this->productGetter = $productGetter;
		$this->em = $entityManager;
		$this->paginator = $paginator;
    }

    /**
     * @Route("/shop", name="shop")
     */
    public function index(Request $request): Response
    {
		$options = [];
		$categoryName = $request->query->get('category');
		$producerNames = $request->query->get('producer');
		$promotion = $request->query->getBoolean('promotion');
		$phraze = $request->query->get('phraze');
		$priceFrom = $request->query->get('priceFrom');
		$priceTo = $request->query->get('priceTo');

		if(!is_null($categoryName)){
			$category = $this->em->getRepository(Category::class)->findOneBy(['name'=>$categoryName]);
			if(!is_null($category)){
				$options['categoryId'] = $category->getId();
			}
		}

		if(!is_null($producerNames)){
			$producers = array_map(function($producerName){
				return $this->em->getRepository(Producer::class)->findOneBy(['name'=>$producerName]);
			}, $producerNames);
			$producers = array_filter($producers, function($producer){return !is_null($producer);});
			if(count($producers) > 0){
				$producerIds = [];
				foreach($producers as $producer){
					array_push($producerIds, $producer->getId());
				}
				$options['producerIds'] = $producerIds;
			}
		}

		if($promotion){
			$options['promotion'] = $promotion;
		}

		if(!is_null($phraze)){
			$options['phraze'] = $phraze;
		}

		if(!is_null($priceFrom)){
			$options['priceFrom'] = floatval($priceFrom);
		}

		if(!is_null($priceTo)){
			$options['priceTo'] = floatval($priceTo);
		}

        $productsQuery = $this->productGetter->getByOptions($options, true);
		$this->paginator->paginate($productsQuery, $request->query->getInt('page', 1), 6);
		
        return $this->render("pages/shop-grid-4-columns-full.twig", [
            "controller_name" => "ShopController",
            "paginator" => $this->paginator,
        ]);
    }
}
