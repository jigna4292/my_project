<?php 
namespace App\Service;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BundleRepository;
use App\Entity\Bundle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Cookie;

class ConverterService
{
    public function initCookie(Request $request, $strSelectedCurrency = NULL ) : Response {
        $response = new Response();

        $cookie = $request->cookies->get( 'selected_currency' );

        if( \is_null( $strSelectedCurrency ) ) {
	        if( \is_null( $cookie ) ) {
	        	$response->headers->setCookie( new Cookie( 'selected_currency', $_ENV['DEFAULT_CURRENCY'] ) ); 
	        } else {
	            $response->headers->setCookie( new Cookie( 'selected_currency', $cookie ));
	        }
	    } else {
	    	 $response->headers->setCookie( new Cookie( 'selected_currency', $strSelectedCurrency ));
	    }

        return $response;
    }

    public function getSetCookieData(Request $request){

        $response = $this->initCookie($request);
        $getCookie = $response->headers->getCookies();

        foreach($getCookie as $cookie){
           if( $cookie->getName() == "selected_currency" ) {
                $setCookie = $cookie->getValue();
           }
        }
        return $setCookie;
    }

    public function getAPIRates(Request $request){

       $api_domain = $_ENV['API_DOMAIN'];
       $access_key = $_ENV['APP_CURRENCY_API_KEY'];

       $currentCurrency = $this->getSetCookieData($request);

       //Create Guzzle Object
       $client = new Client();

        $response = $client->request('GET', $api_domain.'?access_key='.$access_key.'');
        $body = $response->getBody();
        $json = (string) $body;

        // Decode JSON response:
        $response = json_decode($json, true);
        return $response;
    }

    public function priceChange(Request $request, $products, $to = NULL){
    	if($to){
    		$currentCurrency = $to;
    	} else {
    		$currentCurrency = $this->getSetCookieData($request);
    	}
    	$response = $this->getAPIRates($request);
    	$products_array = array();

    	if($response['success'] == 1){
	        $base = $response['rates'][$currentCurrency];      
	        $convert_to_eur = 1/$response['rates'][$_ENV['DEFAULT_CURRENCY']];

	        foreach ($products as $product)
	        {
	            $converted_price_to_eur = $product->getPrice() * $convert_to_eur ;
	            $converted_price = $converted_price_to_eur * $base;

	            array_push($products_array, array(
	                'id' => $product->getId(),
	                'price' => $converted_price
	            ));
	        }
	    }
	    return $products_array;   
    }

    public function singlePriceChange(Request $request, $product_price, $to = NULL){
    	if($to){
    		$currentCurrency = $to;
    	} else {
    		$currentCurrency = $this->getSetCookieData($request);
    	}
    	$response = $this->getAPIRates($request);

    	$converted_price = 0;
    	if($response['success'] == 1){

	        $base = $response['rates'][$currentCurrency];      
	        $convert_to_eur = 1/$response['rates'][$_ENV['DEFAULT_CURRENCY']];

	        $converted_price_to_eur = $product_price * $convert_to_eur ;
	        $converted_price = $converted_price_to_eur * $base;
	    }

	    if($converted_price != 0){
        	return $converted_price;
        } else { ?>
        	<script>alert("Please Update API Key in .ENV file for the price conversion");</script>
       <?php }
    }

    public function getSymbol(Request $request){
    	$symbol = array("USD" => '$',"EUR" => '€', "ZAR" => 'R');
    	$setCookieData = $this->getSetCookieData($request);
    	return $symbol[$setCookieData];
    }
}
?>