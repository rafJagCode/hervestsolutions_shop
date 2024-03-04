<?php
namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;

class CategoryGetter
{
	private $em;

    public function __construct(
		EntityManagerInterface $entityManager,
    ) {
		$this->em = $entityManager;
    }

    public function getCategories()
    {
		$categories = $this->em->getRepository(Category::class)->findAll();
        return $categories;
    }
}
?>
