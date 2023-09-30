<?php
namespace App\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class SeedCategories extends Command
{

	private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

	protected function configure(): void
    {
        $this->setName('seed-categories')
		->setDescription('This command adds categories to db')
		->setHelp('Run this command to add categories to db');
    }

	protected function seedCategories() : void
    {
       $categories = [
		['name'=>'części'],
		['name'=>'oleje'],
		['name'=>'wilgotnościomierze']
	   ];
	   
		foreach($categories as $newCategory){
			$category = new Category();
        	$category->setName($newCategory['name']);

        	$this->entityManager->persist($category);
		}

        $this->entityManager->flush();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
		$this->seedCategories();
        return 1;
    }
}
?>