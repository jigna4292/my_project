<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="products")
     */
     public function index()
    {
       $products = $this->getDoctrine()
	        ->getRepository(Product::class)
	        ->findAll(); 

	    return $this->render('product/index.html.twig', [
	    	'logo_name' => 'Symfony Assignment',
        	'title_sec2' => 'Products Listing',
        	'products' => $products,
        	'copyright_txt' => 'Copyright 2020',
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_single")
     */

    public function show($id)
	{
	    $product = $this->getDoctrine()
	        ->getRepository(Product::class)
	        ->find($id);

	    if (!$product) {
	        throw $this->createNotFoundException(
	            'No product found for id '.$id
	        );
	    }

	    //return new Response('Check out this great product: '.$product->getName());

	    return $this->render('product/single.html.twig', [
	    	'logo_name' => 'Symfony Assignment',
        	'single_product' => $product,
        	'copyright_txt' => 'Copyright 2020',
        ]);

	    // or render a template
	    // in the template, print things with {{ product.name }}
	    // return $this->render('product/show.html.twig', ['product' => $product]);
	}
}
