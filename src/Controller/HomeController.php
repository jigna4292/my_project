<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Repository\ProviderRepository;
use App\Entity\Provider;
use App\Repository\SoftwareRepository;
use App\Entity\Software;
use Doctrine\ORM\EntityManagerInterface;

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
	        ->getRepository(Product::class)
	        ->findAll(); 

        return $this->render('home/index.html.twig', [
        	'logo_name' => 'Symfony Assignment',
        	'title_sec1' => 'Providers Listing',
        	'providers' => $providers,
        	'title_sec2' => 'Products Listing',
        	'products' => $products,
            'copyright_txt' => 'Copyright 2020',
        ]);
    }
}
