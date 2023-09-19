<?php
namespace App\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class SeedProducts extends Command
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
        $this->setName('seed-products')
		->setDescription('This command adds products to db')
		->setHelp('Run this command to add products to db');
    }

	protected function seedProducts() : void
    {
        $products = array(
		array(
			'name' => 'Tłok 87-114900-30',
			'price' => 467,26,
			'quantity' => 1,
			'features' => ['Długość 60,8mm','Otwór o średnicy 79,5mm', 'Sworzeń o średnicy 24mm'],
			'productNumber' => 2,
			'images' => ['images/parts/part1.jpg'],
			'compareAtPrice' => 510,99,
		),
		array(
			'name' => 'Gaźnik DPR Classic Simson SR2 NKJ 123-4',
			'price' => 116,95,
			'quantity' => 5,
			'features' => ['Towar jest fabrycznie nowy','Symbol MF28916', 'Zastosowanie w pojazdach Simson'],
			'productNumber' => 3,
			'images' => ['images/parts/part2.jpg'],
			'compareAtPrice' => 125,99,
		),
		array(
			'name' => 'Chłodnica silnika NISSENS 68001A',
			'price' => 880,54,
			'quantity' => 12,
			'features' => ['Wysokość 608mm','Szerokość 359mm', 'Grubość 26mm'],
			'productNumber' => 4,
			'images' => ['images/parts/part3.jpg'],
			'compareAtPrice' => 915,99,
		),
		array(
			'name' => 'Amortyzator SACHS 310 842',
			'price' => 334,55,
			'quantity' => 4,
			'features' => ['Sposób mocowania amortyzatora: dolne oko/górny trzon','Długość 364mm', 'Gazowy'],
			'productNumber' => 5,
			'images' => ['images/parts/part4.jpg'],
			'compareAtPrice' => 375,66,
		),
		array(
			'name' => 'Massey Ferguson dysza wtryskiwacza',
			'price' => 130,00,
			'quantity' => 15,
			'features' => ['BDN12SPC6290','TYP CIĄGNIKA 35'],
			'productNumber' => 6,
			'images' => ['images/parts/part5.jpg'],
			'compareAtPrice' => 141,22,
		),
		array(
			'name' => 'Rozrusznik BOSCH 0 986 018 950',
			'price' => 884,37,
			'quantity' => 5,
			'features' => ['200-600A','50-300 obr/min'],
			'productNumber' => 7,
			'images' => ['images/parts/part6.jpg'],
			'compareAtPrice' => 899,22,
		),
		array(
			'name' => 'Łożysko SKF 6208-2RS1',
			'price' => 94,32,
			'quantity' => 5,
			'features' => ['Rodzaj łożyskowania	kulkowe zwykłe','Średnica wewnętrzna 40mm', 'Średnica zewnętrzna 80mm'],
			'productNumber' => 8,
			'images' => ['images/parts/part7.jpg'],
			'compareAtPrice' => 115,87,
		),
		array(
			'name' => 'Łożysko SKF 6005-2Z /SKF/',
			'price' => 25,24,
			'quantity' => 50,
			'features' => ['Rodzaj łożyskowania	kulkowe zwykłe','Średnica wewnętrzna 20mm', 'Średnica zewnętrzna 50mm'],
			'productNumber' => 9,
			'images' => ['images/parts/part8.jpg'],
			'compareAtPrice' => 32,44,
		),
		array(
			'name' => 'IMPERGOM 222091 przewód gumowy układu chłodzenia od rury łączącej chłodnicy silnika',
			'price' => 140,66,
			'quantity' => 31,
			'features' => ['Producent IMPERGOM','Indeks	IMP222091', 'Średnica wewnętrzna 32mm'],
			'productNumber' => 10,
			'images' => ['images/parts/part9.jpg'],
			'compareAtPrice' => 151,13,
		),
		);
		foreach($products as $newProduct){
			$product = new Product();
        	$product->setName($newProduct['name']);
        	$product->setPrice($newProduct['price']);
			$product->setQuantity($newProduct['quantity']);
        	$product->setFeatures($newProduct['features']);
			$product->setProductNumber($newProduct['productNumber']);
			$product->setImages($newProduct['images']);
			$product->setCompareAtPrice($newProduct['compareAtPrice']);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        	$this->entityManager->persist($product);
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
		$this->seedProducts();
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