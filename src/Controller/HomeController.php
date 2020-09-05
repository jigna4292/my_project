<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BundleRepository;
use App\Entity\Bundle;
use App\Service\ConverterService;
use App\Repository\ProviderRepository;
use App\Entity\Provider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $converterService = new ConverterService;
        $setCookieData = $converterService->getSetCookieData($request);

    	$providers = $this->getDoctrine()
	        ->getRepository(Provider::class)
	        ->findBy(array(),array('id'=>'ASC'),3,0);
        
        $products = $this->getDoctrine()
            ->getRepository(Bundle::class)
            ->findBy(array(),array('id'=>'ASC'),3,0);

        $getData = array();
        if($setCookieData != $_ENV['DEFAULT_CURRENCY']){
            $getData = $converterService->priceChange($request, $products);
        }

        $getSymbol = $converterService->getSymbol($request);
        $this->get('twig')->addGlobal('symbol', $getSymbol);

        return $this->render('home/index.html.twig', [
            'title_sec1' => 'Provider Listing',
            'providers' => $providers,
            'title_sec2' => 'Bundle Listing',
            'products' => $products,
            'product_price' => $getData
        ]);
    }
}
