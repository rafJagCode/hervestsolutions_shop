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
			'name' => 'annaburger',
			'image' => 'images/producers/annaburger.svg',
			'link' => 'https://www.annaburger.de/en/'
		),
		array(
			'name' => 'cynkomet',
			'image' => 'images/producers/cynkomet.svg',
			'link' => 'https://cynkomet.pl/'
		),
		array(
			'name' => 'case',
			'image' => 'images/producers/case.svg',
			'link' => 'https://www.caseih.com/pl-pl/poland'
		),
		array(
			'name' => 'lemken',
			'image' => 'images/producers/lemken.svg',
			'link' => 'https://lemken.com/en-en/'
		),
		array(
			'name' => 'manitou',
			'image' => 'images/producers/manitou.svg',
			'link' => 'https://www.manitou.com/pl-PL'
		),
		array(
			'name' => 'steyr',
			'image' => 'images/producers/steyr.svg',
			'link' => 'https://www.steyr-traktoren.com/pl-pl/rolnictwo'
		),
		array(
			'name' => 'strautman',
			'image' => 'images/producers/stratman.svg',
			'link' => 'https://www.strautmann.com/pl'
		),
		array(
			'name' => 'john deere',
			'image' => 'images/producers/john-deere.svg',
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