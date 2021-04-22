<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SearchController extends AbstractController
{
	private $http;
	public function __construct(HttpClientInterface $http)
	{
		$this->http = $http;
	}
    /**
     * @Route("/search-results/{input}", name="search-results")
     */
    public function searchProducts($input): Response
    {
		$response = $this->http->request('GET', 'http://redpart.test/search-in-products/' . $input);

		if($response->getStatusCode()===200){
			return $this->render('components/search-results.twig', [
			'controller_name' => 'SearchController',
			'searchResults' => $response->toArray(),
			]);
		}
    }
}
