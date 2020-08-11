<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProviderRepository;
use App\Entity\Provider;
use Doctrine\ORM\EntityManagerInterface;

class ProviderController extends AbstractController
{
    /**
     * @Route("/provider", name="providers")
     */
    public function index()
    {
    	$providers = $this->getDoctrine()
	        ->getRepository(Provider::class)
	        ->findAll();

        return $this->render('provider/index.html.twig', [
            'title_sec' => 'Provider Listing',
            'providers' => $providers
        ]);
    }

    /**
     * @Route("/provider/{id}", name="provider_single")
     */

    public function show($id)
	{
	    $provider = $this->getDoctrine()
	        ->getRepository(Provider::class)
	        ->find($id);

	    if (!$provider) {
	        throw $this->createNotFoundException(
	            'No product found for id '.$id
	        );
	    }

	    //return new Response('Check out this great product: '.$product->getName());

	    return $this->render('provider/single.html.twig', [
        	'single_provider' => $provider,
        ]);
	}
}
