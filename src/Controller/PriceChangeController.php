<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BundleRepository;
use App\Entity\Bundle;
use App\Service\ConverterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

class PriceChangeController
{
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/getRate", name="getRateAjax")
     */

    public function getRate(Request $request)
    {
        $to = $request->query->get('to');
        $converterService = new ConverterService;
        $products = $this->em
                ->getRepository(Bundle::class)
                ->findAll();

        $getPrice = $converterService->priceChange($request, $products, $to);

        return new JsonResponse(array(
                'status' => 'OK',
                'message' =>$getPrice),
            200); 
    }

    /**
     * @Route("/changeCurrency", name="changeCurrencyAjax")
     */

    public function changeCurrency(Request $request)
    {
       $converterService = new ConverterService;
       $strSelectedCurrency =  $request->query->get('to');

       $response = $converterService->initCookie($request,$strSelectedCurrency);
       return $response; 
    }
}
