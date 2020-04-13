<?php


namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="app_home", methods={"GET","POST"})
     */
    public function showPost()
    {

        $em = $this->getDoctrine()->getManager();
        /** @var $Post Post */
        $Post = $em->getRepository(Post::class);
        $listOutputPost = $Post->findAll();

        return $this->render('home/home.html.twig', [
            'listOutputPost' => $listOutputPost, //передає змінну в темплейт для роботи з ним з допомогою циклу
        ]);

    }


}