<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="app_home", methods={"GET","POST"})
     */
    public function new()
    {

        return $this->render('home/home.html.twig', [

        ]);

    }


}