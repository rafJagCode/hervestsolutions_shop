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
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;

        parent::__construct();
    }

	protected function configure(): void
    {
		// Use in-build functions to set name, description and help
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
		),
		array(
			'name' => 'arbos',
			'image' => 'images/producers/arbos.png',
		),
		array(
			'name' => 'case',
			'image' => 'images/producers/case.png',
		),
		array(
			'name' => 'cat',
			'image' => 'images/producers/cat.png',
		),
		array(
			'name' => 'claas',
			'image' => 'images/producers/claas.png',
		),
		array(
			'name' => 'krone',
			'image' => 'images/producers/krone.png',
		),
		array(
			'name' => 'massey_ferguson',
			'image' => 'images/producers/massey_ferguson.png',
		),
		);
		foreach($producers as $newProducer){
			$producer = new Producer();
        	$producer->setName($newProducer['name']);
			$producer->setImage($newProducer['image']);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        	$this->entityManager->persist($producer);
		}

        // actually executes the queries (i.e. the INSERT query)
        $this->entityManager->flush();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
		$this->seedProducers();
        return 1;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
?>