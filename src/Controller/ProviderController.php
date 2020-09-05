<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProviderRepository;
use App\Entity\Provider;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ConverterService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProviderController extends AbstractController
{
    /**
     * @Route("/provider", name="providers")
     */
    public function index(Request $request)
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

    public function show(Request $request,$id)
	{
        $converterService = new ConverterService;
        $setCookieData = $converterService->getSetCookieData($request);

	    $provider = $this->getDoctrine()
	        ->getRepository(Provider::class)
	        ->find($id);

        $products = $provider->getBundles();

	    if (!$provider) {
	        return $this->render('error.html.twig', [
                 'page_title' => '404 Page Not Found',
                 'message' => 'Sorry, Provider Not Found !!!'
             ]);
	    }

        $getData = array();
        if($setCookieData != $_ENV['DEFAULT_CURRENCY']){
            $getData = $converterService->priceChange($request, $products);
        }

        $getSymbol = $converterService->getSymbol($request);
        $this->get('twig')->addGlobal('symbol', $getSymbol);

	    return $this->render('provider/single.html.twig', [
        	'single_provider' => $provider,
            'product_price' => $getData
        ]);
	}
}
