<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BundleRepository;
use App\Entity\Bundle;
use App\Service\ConverterService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BundleController extends AbstractController
{
    /**
     * @Route("/bundle", name="bundles")
     */
    public function index(Request $request)
    {        
        $converterService = new ConverterService;
        $setCookieData = $converterService->getSetCookieData($request);

        $products = $this->getDoctrine()
            ->getRepository(Bundle::class)
            ->findAll(); 

        $getData = array();
        if($setCookieData != $_ENV['DEFAULT_CURRENCY']){
            $getData = $converterService->priceChange($request, $products);
        }

        $getSymbol = $converterService->getSymbol($request);
        $this->get('twig')->addGlobal('symbol', $getSymbol);

        return $this->render('bundle/index.html.twig', [
            'title_sec2' => 'Bundle Listing',
            'products' => $products,
            'product_price' => $getData
        ]);
    }


    /**
     * @Route("/bundle/{id}", name="bundle_single")
     */

    public function show(Request $request, $id)
	{
        $converterService = new ConverterService;
        $setCookieData = $converterService->getSetCookieData($request);

	    $product = $this->getDoctrine()
	        ->getRepository(Bundle::class)
	        ->find($id);

        $getPrice = "";

        if($setCookieData != $_ENV['DEFAULT_CURRENCY']){
            $getPrice = $converterService->singlePriceChange($request, $product->getPrice());
        }
        
        $getSymbol = $converterService->getSymbol($request);
        $this->get('twig')->addGlobal('symbol', $getSymbol);

        if (!$product) {          
            return $this->render('error.html.twig', [
                 'page_title' => '404 Page Not Found',
                 'message' => 'Sorry, Bundle Not Found !!!'
             ]);
        }

	    return $this->render('bundle/single.html.twig', [
        	'single_product' => $product,
            'product_price' => $getPrice
        ]);
	}
}