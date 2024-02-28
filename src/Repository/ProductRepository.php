<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findNewest()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.addedDate', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findBestSellers()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.sold', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findPopular()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.visited', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findByOptions($options, $returnQuery=false)
    {
		$default = ['categoryId' => null, 'producerIds' => null, 'excludedId' => null, 'promotion' => null, 'phraze' => null, 'priceFrom' => null, 'priceTo' => null];
  		$options = (object) array_merge($default, $options);

        $qb = $this->createQueryBuilder('p');

		if(!is_null($options->categoryId)){
			$qb->andWhere('p.category = :categoryId')
            ->setParameter('categoryId', $options->categoryId);
		};

		if(!is_null($options->producerIds)){
			$qb->andWhere('p.producer IN (:producerIds)')
			->setParameter('producerIds', $options->producerIds);
		};

		if(!is_null($options->excludedId)){
			$qb->andWhere('p.id != :excludedId')
            ->setParameter('excludedId', $options->excludedId);
		}

		if(!is_null($options->promotion)){
			$qb->andWhere('p.promotion = :promotion')
            ->setParameter('promotion', $options->promotion);	
		}

		if(!is_null($options->phraze)){
			$qb->andWhere('p.name LIKE :phraze')
			->setParameter('phraze', '%'.$options->phraze.'%');
		}

		if(!is_null($options->priceFrom)){
			$qb->andWhere('p.price >= :priceFrom')
			->setParameter('priceFrom', $options->priceFrom);
		}

		if(!is_null($options->priceTo)){
			$qb->andWhere('p.price <= :priceTo')
			->setParameter('priceTo', $options->priceTo);
		}

		if($returnQuery) return $qb;

		return $qb
		->getQuery()
		->getResult();
    }
	   
    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findByPhraze($phraze, $limit=null)
    {
        $qb = $this->createQueryBuilder('p')->andWhere('p.name LIKE :phraze')->setParameter('phraze', '%'.$phraze.'%');

		if($limit) $qb->setMaxResults($limit);
            
		return $qb->getQuery()->getResult();
    }

}
