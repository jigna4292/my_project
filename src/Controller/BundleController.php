<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BundleRepository;
use App\Entity\Bundle;

class BundleController extends AbstractController
{
    /**
     * @Route("/bundle", name="bundles")
     */
    public function index()
    {
        $products = $this->getDoctrine()
            ->getRepository(Bundle::class)
            ->findAll(); 

        return $this->render('bundle/index.html.twig', [
            'title_sec2' => 'Bundle Listing',
            'products' => $products
        ]);
    }


    /**
     * @Route("/bundle/{id}", name="bundle_single")
     */

    public function show($id)
	{
	    $product = $this->getDoctrine()
	        ->getRepository(Bundle::class)
	        ->find($id);

	    if (!$product) {
	        throw $this->createNotFoundException(
	            'No bundle found for id '.$id
	        );
	    }

	    //return new Response('Check out this great product: '.$product->getName());

	    return $this->render('bundle/single.html.twig', [
        	'single_product' => $product,
        ]);

	}
}
