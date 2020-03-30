<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;

class headerController extends AbstractController
{

    public function headerFunction(AuthenticationUtils $authenticationUtils): Response
    {

        if ($this->getUser()) {
            $statusAuthorization = true;
        } else {
            $statusAuthorization = false;
        }

        return $this->render(
            'header.html.twig',
            ['statusAuthorization' => $statusAuthorization]
        );
    }


}