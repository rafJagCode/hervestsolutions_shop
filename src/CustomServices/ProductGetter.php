<?php
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class ProductGetter
{
    private $client;
    private $flash;
	private $em;

    public function __construct(
        HttpClientInterface $client,
        FlashBagInterface $flash,
		EntityManagerInterface $entityManager,
    ) {
        $this->client = $client;
        $this->flash = $flash;
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

    public function getProductsByBrand($brand)
    {
		$products = $this->em->getRepository(Product::class)->findAll();
        return $products;
    }

    public function getNewest()
    {
		$products = $this->em->getRepository(Product::class)->findAll();
        return $products;
    }

    public function getPopular()
    {
		$products = $this->em->getRepository(Product::class)->findAll();
        return $products;
    }

    public function getBestSellers()
    {
		$products = $this->em->getRepository(Product::class)->findAll();
        return $products;
    }

	public function search($phraze)
    {
		$products = $this->em->getRepository(Product::class)->findAll();
		$searchResult = array_filter($products, function($product) use($phraze){
			$regex = "/" . $phraze . "/";
			return (preg_match($regex, $product->getName()));
		});

        return $searchResult;
    }
}
?>
