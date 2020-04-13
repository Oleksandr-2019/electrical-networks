<?php

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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;//для роботи з файлами - тут для використання можливосты видалення


/**
 * @Route("/post")
 */
class PostController extends AbstractController
{

    /**
     * @Route("/new", name="post_new")
     */
    public function postNew (Request $request): Response
    {

        //Визначаєм користувача який зайшов на сторінку для його запису в таблицю поста
        $currentUser= $this->getUser();

        //Записуєм пост
        $myNewPost = new Post();
        //Записуєм поточного користувача в екземпляр поста
        $myNewPost->setUser($currentUser)
            ->setDateCreationPost(new \DateTime('now'));

        $formPost = $this->createForm(PostType::class, $myNewPost);
        $formPost->handleRequest($request);

        if ($formPost->isSubmitted() && $formPost->isValid() ) {
            //Отримуєм назву файла картинки для зміни її назви в майбутньому
            $postTpFileFile = $formPost['nameMainImagePost']->getData();
            // ця умова необхідна, оскільки поле "schemeTp" не обов'язкове
            // тому файл PDF повинен оброблятися лише при завантаженні файлу
            if ($postTpFileFile) {
                $originalFilename = pathinfo($postTpFileFile->getClientOriginalName(), PATHINFO_FILENAME);

                // це потрібно для безпечного включення імені файла до складу URL-адреси
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);

                $newFilename = $safeFilename.'-'.uniqid().'.'.$postTpFileFile->guessExtension();
                //Перемістіть файл у каталог, де зберігаються брошури
                try {
                    $postTpFileFile->move(
                        $this->getParameter('post_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ...обробляти виняток, якщо щось відбувається під час завантаження файлу
                }

                // оновлює властивість 'brochureFilename' для зберігання імені файлу PDF
                // замість її змісту
                $myNewPost->setNameMainImagePost($newFilename);
            }

            // Запис даних в базу даних (не обовязково для запису сомого файлу на сервер)
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($myNewPost);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('app_home'));
        }


        return $this->render('post/post-new.html.twig', [
            'formPost' => $formPost->createView(),
        ]);

    }

    /**
     * @Route("/detailed/{postSlug}", name="post_detailed", methods={"GET"})
     * @param Post $post
     * @param Request $request
     * @return Response
     * @ParamConverter("post", options={"mapping" : {"postSlug" : "slug"}})
     */

    public function postDetailed (Post $post, Request $request): Response
    {
        return $this->render('post/post-detailed.html.twig', [
            'postSlug' => $post->getSlug(),
            'post' => $post
        ]);
    }

}
