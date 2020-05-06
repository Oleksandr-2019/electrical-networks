<?php


namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods={"GET","POST"})
     */
    public function showPost(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var $PostRepository Repository */
        $PostRepository = $em->getRepository(Post::class);
        $allPostQuery = $PostRepository->createQueryBuilder('p') //->findAll();
            ->where('p.textPost IS NOT NULL')
            ->getQuery();
        $listOutputPost = $paginator->paginate(
            $allPostQuery, 
            $request->query->getInt('page', 1), 
            5
        );

        return $this->render('home/home.html.twig', [
            'listOutputPost' => $listOutputPost,
        ]);
    }
}
