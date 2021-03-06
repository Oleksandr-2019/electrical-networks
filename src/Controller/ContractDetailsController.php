<?php

// src/Controller/ContractDetailsController.php
namespace App\Controller;

use App\Entity\ContractDetails;
use App\Repository\ContractDetailsRepository;
use App\Form\ContractDetailsType;
use App\Form\showContractDetailsType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/contract_details")
 */
class ContractDetailsController extends AbstractController
{
    /**
     * @Route("/show", name="show_contract_details")
     */
    public function showContractDetailsFunc (Request $request)
    {
        $contractDetails = new ContractDetails();
        $form = $this->createForm(showContractDetailsType::class, $contractDetails);
        $form->handleRequest($request);

        //змінна яка блокує помилку Notice: Undefined variable: showContractDetails
        //при завантаженні сторінки коли ще запит не відправления
        $showContractDetails = false;

                if ($form->isSubmitted() && $form->isValid()) {
            /*
                    var_dump($contractDetails);
                    var_dump($contractDetails->getContractNumber());
            */

                    $entityManager = $this->getDoctrine()->getManager();

                    //перевірка якщо перше поле пусте то шукати по другому
                    //якщо друге поле пусте то шукати по першому
                    if ($contractDetails->getContractNumber() != null ) {
                        $showContractDetails = $entityManager->getRepository(ContractDetails::class)->findOneBy(['contractNumber' => $contractDetails->getContractNumber()]);
                        //var_dump($contractDetails->getContractNumber());
                        var_dump('Номер');
                    } else {

                        //$showContractDetails = $entityManager->getRepository(ContractDetails::class)->findBy(['nameContract' => $contractDetails->getNameContract()]);
                        // from inside a controller
                        //$testName = 'Черкаський державний технологічний університет';
                        $testName = 'Черкаський державний';

                        $responseListContract = $this->getDoctrine()
                            ->getRepository(ContractDetails::class)
                            ->findAllContract($testName);

                        var_dump('Назва');
                        var_dump($responseListContract);


                    }

                    //var_dump($showContractDetails);
                    //return $showContractDetails;
                }

        return $this->render('contractDetails/contract_details-show.html.twig', [
            'form' => $form->createView(),
            'showContractDetails' => $showContractDetails
        ]);
    }

    /**
     * @Route("/new", name="new_contract_details")
     */
    public function newContractDetailsFunc(Request $request)
    {
        $contractDetails = new ContractDetails();
        $form = $this->createForm(ContractDetailsType::class, $contractDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contractDetails);
            $entityManager->flush();
            // зберігати змінну продукту $ або будь-яку іншу роботу
            //var_dump($contractDetails);
            return $this->redirect($this->generateUrl('app_home'));
        }


        return $this->render('contractDetails/contract_details.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/update/{numberContractDetailsFoUpdate}", name="update_contract_details")
     */
    public function updateContractDetailsFunc($numberContractDetailsFoUpdate, Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $contractDetails = $entityManager->getRepository(ContractDetails::class)->findOneBy(['contractNumber' => $numberContractDetailsFoUpdate]);

        $form = $this->createForm(ContractDetailsType::class, $contractDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contractDetails);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('app_home'));
        }

        return $this->render('contractDetails/contract_details.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}