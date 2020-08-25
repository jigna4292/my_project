<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BundleRepository;
use App\Entity\Bundle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;

class GetPriceController
{
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/getPrice", name="getPriceAjax")
     */

   public function getPrice(){

        // set API Endpoint and API key 
        $get_request = Request::createFromGlobals();
        $endpoint =  $get_request->query->get('endpoint');
        $access_key = $get_request->query->get('key');

        //Create Guzzle Object
        $client = new Client();

        $response = $client->request('GET', 'http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'');
        $body = $response->getBody();
        $json = (string) $body;

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        if( $exchangeRates['success'] == 1){
            //Process id Get Sucess is equal to 1

            $products = $this->em
                ->getRepository(Bundle::class)
                ->findAll(); 

            $to =  $get_request->query->get('to');
            $base = $exchangeRates['rates'][$to];      
            $convert_to_eur = 1/$exchangeRates['rates']["USD"];

            $products_array = array();
            foreach ($products as $product)
            {
                $converted_price_to_eur = $product->getPrice() * $convert_to_eur ;
                $converted_price = $converted_price_to_eur * $base;

                array_push($products_array, array(
                    'id' => $product->getId(),
                    'price' => $converted_price
                ));
            }

            return new JsonResponse(array(
                'status' => 'OK',
                'message' =>$products_array),
            200); 
        } else {
            //Return Error array of the API
            return new JsonResponse(array(
                'status' => 'OK',
                'message' =>$exchangeRates),
            200); 
        }
    }

}
