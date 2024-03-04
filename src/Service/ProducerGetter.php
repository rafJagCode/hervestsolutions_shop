<?php
namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Producer;

class ProducerGetter
{
	private $em;

    public function __construct(
		EntityManagerInterface $entityManager,
    ) {
		$this->em = $entityManager;
    }

    public function getProducers()
    {
		$producers = $this->em->getRepository(Producer::class)->findAll();
        return $producers;
    }
}
?>
