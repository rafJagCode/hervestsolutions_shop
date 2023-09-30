<?php
namespace App\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Producer;
use Doctrine\ORM\EntityManagerInterface;

class SeedProducers extends Command
{

	private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

	protected function configure(): void
    {
        $this->setName('seed-producers')
		->setDescription('This command adds producers to db')
		->setHelp('Run this command to add producers to db');
    }

	protected function seedProducers() : void
    {
        $producers = array(
		array(
			'name' => 'agco',
			'image' => 'images/producers/agco.png',
			'link' => 'https://www.agcocorp.pl/'
		),
		array(
			'name' => 'arbos',
			'image' => 'images/producers/arbos.png',
			'link' => 'https://www.arbos.com/'
		),
		array(
			'name' => 'case',
			'image' => 'images/producers/case.png',
			'link' => 'https://www.caseih.com/emea/pl-pl'
		),
		array(
			'name' => 'cat',
			'image' => 'images/producers/cat.png',
			'link' => 'https://www.cat.com/pl_PL.html'
		),
		array(
			'name' => 'claas',
			'image' => 'images/producers/claas.png',
			'link' => 'https://www.claas.pl/'
		),
		array(
			'name' => 'krone',
			'image' => 'images/producers/krone.png',
			'link' => 'https://www.krone-agriculture.com/en/'
		),
		array(
			'name' => 'massey ferguson',
			'image' => 'images/producers/massey_ferguson.png',
			'link' => 'https://www.masseyferguson.com/en.html'
		),
		array(
			'name' => 'john deere',
			'image' => 'images/producers/john_deere.png',
			'link' => 'https://www.deere.pl/pl/index.html'
		),
		);
		foreach($producers as $newProducer){
			$producer = new Producer();
        	$producer->setName($newProducer['name']);
			$producer->setImage($newProducer['image']);
			$producer->setLink($newProducer['link']);

        	$this->entityManager->persist($producer);
		}

        $this->entityManager->flush();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
		$this->seedProducers();
        return 1;
    }
}
?>