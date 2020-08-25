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
	        return $this->render('error.html.twig', [
                 'page_title' => '404 Page Not Found',
                 'message' => 'Sorry, Provider Not Found !!!'
             ]);
	    }

	    return $this->render('provider/single.html.twig', [
        	'single_provider' => $provider,
        ]);
	}
}
