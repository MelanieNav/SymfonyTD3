<?php

namespace App\Controller;

use App\Services\semantic\IndexGui;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Services\semantic\SemanticGui;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(IndexGui $gui){
    	$gui->getOnClick(".elements","", "#block-body",["attr"=>"data-ajax"]);
    	$gui->getOnClick("#menu a[data-ajax]","","#block-body",["attr"=>"data-ajax"]);
        $entityManager = $this->getDoctrine()->getManager();
    	$gui->board($entityManager);
        return $gui->renderView("index.html.twig");
    }
}
