<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BundleRepository;
use App\Entity\Bundle;
use App\Repository\ProviderRepository;
use App\Entity\Provider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
    	$providers = $this->getDoctrine()
	        ->getRepository(Provider::class)
	        ->findAll(); 

    	$products = $this->getDoctrine()
	        ->getRepository(Bundle::class)
	        ->findAll(); 

        return $this->render('home/index.html.twig', [
            'title_sec1' => 'Provider Listing',
            'providers' => $providers,
            'title_sec2' => 'Bundle Listing',
            'products' => $products
        ]);
    }

    /**
     * @Route("/productajax", name="getProductsAjax")
     */
    public function getProductsAjax()
    { 

        $products = $this->getDoctrine()
            ->getRepository(Bundle::class)
            ->findAll(); 

        $products_array = array();
        foreach ($products as $product)
        {
            array_push($products_array, array(
                'id' => $product->getId(),
                'price' => $product->getPrice()
            ));
        }
        
        // Send all this back to client
        return new JsonResponse(array(
            'status' => 'OK',
            'message' => $products_array),
        200);

    }
}
