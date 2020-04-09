<?php

// src/Controller/ContractDetailsController.php
namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\ContractDetails;
use App\Repository\PostRepository;
use App\Form\PostType;
use App\Form\showContractDetailsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{

    /**
     * @Route("/new", name="post_new")
     */
    public function postNew(Request $request): Response
    {

        //Визначаєм користувача який зайшов на сторінку для його запису в таблицю поста
        $currentUser= $this->getUser();

        //Записуєм пост
        $myNewPost = new Post();

        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(PostType::class, $myNewPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //Записуєм поточного користувача в екземпляр поста
            $myNewPost->setUser($currentUser);
            //Записуєм пост в базу даних
            $entityManager->persist($myNewPost);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('app_home'));
        }


        return $this->render('post/post-new.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}