<?php 
	
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;

Class MyFirstController{
	public function homepage(){
		return new Response('My First Controller');
	}
}