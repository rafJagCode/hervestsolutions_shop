<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CsvController extends AbstractController
{
	/**
	 * @Route("/read-csv", name="read-csv")
	 */
	public function readCsv(): Response
	{
		$products = [];
		$fileName = 'test.csv';

		$file = fopen($fileName, "r");

		while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
			//name,description,quantity,price,product_number,features

			$productName = $column[0];
			$description = $column[1];
			$quantity = $column[2];
			$price = $column[3];
			$product_number = $column[4];
			$features = $column[5];
			$product = (object)['name' => $productName, 'description' => $description, 'quantity' => $quantity, 'price' => $price, 'product_number' => $product_number, 'features' => $features];
			array_push($products, $product);
		}

		dump($products);
		exit();
	}

	/**
	 * @Route("/upload-csv", name="upload-csv")
	 */
	public function uploadCsv()
	{
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;

		// Check if it is csv file
		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

		if (isset($_FILES['file']['tmp_name'])) {
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
			echo in_array($mime, $csvMimes) === true ? 'It is a CSV' : 'It is not CSV';
			finfo_close($finfo);
		}

		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}

		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}


		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				return new Response("The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.");
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}
}
