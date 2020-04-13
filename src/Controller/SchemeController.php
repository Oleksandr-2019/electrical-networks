<?php

// src/Controller/SchemeController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Collator;


use App\Entity\SchemesTp;
use App\Form\SchemesTpType;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;//для роботи з файлами - тут для використання можливосты видалення


/**
 * @Route("/scheme")
 */
class SchemeController extends AbstractController
{
    /**
     * @Route("/tp/new", name="scheme_tp", methods={"GET","POST"})
     */
    public function showSchemeTP(Request $request)
    {
        $schemesTp = new SchemesTp();
        $form = $this->createForm(SchemesTpType::class, $schemesTp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $schemeTpFile */
            //Отримуєм назву файла картинки для зміни її назви в майбутньому
            $schemeTpFile = $form['schemeTp']->getData();
            $numberTPString = $form['numberTP']->getData();

            //
            // Перевірка чи існує вже такий запис в базі даних
            //
            //отримує з бази даних всі записи по ТП
            $em = $this->getDoctrine()->getManager();

            $checkBase = $em->getRepository(SchemesTp::class);

            $listSchemesTp = $checkBase->findAll();

            //перебирає всю базу і шукає чи вже існую номерт такої ТП чи ні
            for($i=0; $i<count($listSchemesTp); $i++ ) {

                if ($listSchemesTp[$i]->getNumberTp() == $numberTPString) {

                    $existingTp = true;
                    return $this->render('scheme/scheme-tp-download.html.twig', [
                        'form' => $form->createView(),
                        'statementFact' => $existingTp
                    ]);

                }

            }

            // ця умова необхідна, оскільки поле "schemeTp" не обов'язкове
            // тому файл PDF повинен оброблятися лише при завантаженні файлу
            if ($schemeTpFile) {
                $originalFilename = pathinfo($schemeTpFile->getClientOriginalName(), PATHINFO_FILENAME);

                // це потрібно для безпечного включення імені файла до складу URL-адреси
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);

                $newFilename = $safeFilename.'-'.uniqid().'.'.$schemeTpFile->guessExtension();
                /*
                                $schemesTp->setSchemeTpFilename(
                                    new File($this->getParameter('schemeTp_directory').'/'.$schemesTp->getSchemeTpFilename())
                                );
                */
                //Перемістіть файл у каталог, де зберігаються брошури
                try {
                    $schemeTpFile->move(
                        $this->getParameter('schemeTp_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ...обробляти виняток, якщо щось відбувається під час завантаження файлу
                }


                // оновлює властивість 'brochureFilename' для зберігання імені файлу PDF
                // замість її змісту

                $schemesTp->setSchemeTpFilename($newFilename);


                // Запис даних в базу даних (не обовязково для запису сомого файлу на сервер)
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($schemesTp);
                $entityManager->flush();

            }

            // ...зберігати змінну продукту $ або будь-яку іншу роботу

            return $this->redirect($this->generateUrl('app_home'));
        }

        return $this->render('scheme/scheme-tp-download.html.twig', [
            'form' => $form->createView(),
            'statementFact' => false
        ]);

    }

    /**
     * @Route("/tp/show", name="show_scheme_tp", methods={"GET","POST"})
     */
    public function showSchemesTp ()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var SchemesTp $schemesTp */
        $schemesTp = $em->getRepository(SchemesTp::class);
        $listSchemesTp = $schemesTp->findAll();

        return $this->render('scheme/scheme-tp-show.html.twig', [
            'schemesTp' => $listSchemesTp, //передає змінну в темплейт для роботи з ним з допомогою циклу
        ]);

    }

    /**
     * @Route("/tp/update/{numberTpFoUpdate}", name="update_scheme_tp", methods={"GET","POST"})
     */
    public function updateSchemesTp ($numberTpFoUpdate, Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $schemesTp = $entityManager->getRepository(SchemesTp::class)->findOneBy(['numberTP' => $numberTpFoUpdate]);

        //для видалення старої схеми якщо нова буде завантажуватись
        $oldSchemeTpFilename = $schemesTp->getSchemeTpFilename();


        // створення форми
        $form = $this->createForm(SchemesTpType::class, $schemesTp);
        $form->handleRequest($request);

        //для видалення старої схеми якщо нова буде завантажуватись
        $filesystem = new Filesystem();

        //дії якщо форма надіслана і валідна
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $schemeTpFile */
            $schemeTpFile = $form['schemeTp']->getData();

            // ця умова необхідна, оскільки поле "schemeTp" не обов'язкове
            // тому файл PDF повинен оброблятися лише при завантаженні файлу
            if ($schemeTpFile) {
                $originalFilename = pathinfo($schemeTpFile->getClientOriginalName(), PATHINFO_FILENAME);

                // це потрібно для безпечного включення імені файла до складу URL-адреси
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);

                $newFilename = $safeFilename.'-'.uniqid().'.'.$schemeTpFile->guessExtension();

                /*
                    $schemesTp->setSchemeTpFilename(
                        new File($this->getParameter('schemeTp_directory').'/'.$schemesTp->getSchemeTpFilename())
                    );
                */


                try {
                    //Видалить стару схему
                    $filesystem->remove(
                        $this->getParameter('schemeTp_directory').'/'.$oldSchemeTpFilename
                    );
                    //Перемістіть схему у каталог, де зберігаються схеми
                    $schemeTpFile->move(
                        $this->getParameter('schemeTp_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ...обробляти виняток, якщо щось відбувається під час завантаження файлу
                }

                // оновлює властивість 'brochureFilename' для зберігання імені файлу PDF замість її змісту
                $schemesTp->setSchemeTpFilename($newFilename);

            }

            // Запис даних в базу даних (не обовязково для запису сомого файлу на сервер)
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($schemesTp);
            $entityManager->flush();

            // ...зберігати змінну продукту $ або будь-яку іншу роботу

            //return $this->redirect($this->generateUrl('page_home'));
        }

        return $this->render('scheme/scheme-tp-update.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}
