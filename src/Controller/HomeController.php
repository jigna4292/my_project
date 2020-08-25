<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BundleRepository;
use App\Entity\Bundle;
use App\Repository\ProviderRepository;
use App\Entity\Provider;
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
	        ->findBy(array(),array('id'=>'ASC'),3,0);
        
        $products = $this->getDoctrine()
            ->getRepository(Bundle::class)
            ->findBy(array(),array('id'=>'ASC'),3,0);


        return $this->render('home/index.html.twig', [
            'title_sec1' => 'Provider Listing',
            'providers' => $providers,
            'title_sec2' => 'Bundle Listing',
            'products' => $products
        ]);
    }
}
