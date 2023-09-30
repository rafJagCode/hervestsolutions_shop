<?php
namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class ProductGetter
{
	private $em;

    public function __construct(
		EntityManagerInterface $entityManager,
    ) {
		$this->em = $entityManager;
    }

    public function getProduct($id)
    {
		$product = $this->em->getRepository(Product::class)->find($id);
        return $product;
    }

    public function getProducts()
    {
		$products = $this->em->getRepository(Product::class)->findAll();
        return $products;
    }

    public function getNewest()
    {
		$products = $this->em->getRepository(Product::class)->findNewest();
        return $products;
    }

    public function getPopular()
    {
		$products = $this->em->getRepository(Product::class)->findPopular();
        return $products;
    }

    public function getBestSellers()
    {
		$products = $this->em->getRepository(Product::class)->findBestSellers();
        return $products;
    }

	public function getByOptions($options, $returnQuery=false){
		$products = $this->em->getRepository(Product::class)->findByOptions($options, $returnQuery);
		return $products;
	}

	public function getByPhraze($phraze)
    {
		$products = $this->em->getRepository(Product::class)->findByPhraze($phraze);
		// $searchResult = array_filter($products, function($product) use($phraze){
		// 	$regex = "/" . $phraze . "/";
		// 	return (preg_match($regex, $product->getName()));
		// });

        return $products;
    }
}
?>
