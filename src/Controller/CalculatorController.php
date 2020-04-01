<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculatorController extends AbstractController
{
    private $baseTable = [
        11 => [
            1 => 5.00, 3 => 3.85, 6 => 3.23, 9 => 2.72, 12 => 2.36, 
            15 => 2.10, 18 => 1.91, 24 => 1.65, 40 => 1.31, 60 => 1.14, 
            100 => 1.00, 200 => 0.87, 400 => 0.74, 600 => 0.66, 1000 => 0.60,
        ],
        12 => [
            1 => 6.50, 3 => 5.01, 6 => 4.20, 9 => 3.53, 12 => 3.07, 
            15 => 2.73, 18 => 2.48, 24 => 2.15, 40 => 1.70, 60 => 1.48, 
            100 => 1.30, 200 => 1.12, 400 => 0.96, 600 => 0.86, 1000 => 0.78,
        ],
        13 => [
            1 => 10.0, 3 => 8.19, 6 => 5.56, 9 => 4.44, 12 => 3.76, 
            15 => 3.33, 18 => 3.05, 24 => 2.72, 40 => 2.35, 60 => 2.10, 
            100 => 1.73, 200 => 1.38, 400 => 1.31, 600 => 1.19, 1000 => 1.10,
        ],
        14 => [
            1 => 12.0, 3 => 9.83, 6 => 6.67, 9 => 5.33, 12 => 4.51, 
            15 => 3.99, 18 => 3.66, 24 => 3.26, 40 => 2.82, 60 => 2.52, 
            100 => 2.08, 200 => 1.65, 400 => 1.58, 600 => 1.43, 1000 => 1.32,
        ],
        15 => [
            1 => 3.50, 3 => 2.84, 6 => 1.91, 9 => 1.47, 12 => 1.22, 
            15 => 1.07, 18 => 0.96, 24 => 0.83, 40 => 0.66, 60 => 0.58, 
            100 => 0.52, 200 => 0.48, 400 => 0.47, 600 => 0.46, 1000 => 0.41,
        ],
        21 => [
            1 => 9.00, 3 => 6.33, 6 => 5.29, 9 => 4.36, 12 => 3.72, 
            15 => 3.26, 18 => 2.94, 24 => 2.51, 40 => 2.00, 60 => 1.78, 
            100 => 1.62, 200 => 1.47, 400 => 1.24, 600 => 1.08, 1000 => 0.99,
        ],
        22 => [
            1 => 16.0, 3 => 13.05, 6 => 8.34, 9 => 6.41, 12 => 5.39, 
            15 => 4.77, 18 => 4.36, 24 => 3.83, 40 => 3.18, 60 => 2.83, 
            100 => 2.51, 200 => 2.16, 400 => 1.88, 600 => 1.77, 1000 => 1.76,
        ],
    ];

    private function calc(int $type, int $number): float
    {
        $key1 = 0;
        $value1 = 0;
        foreach ($this->baseTable[$type] as $key => $value)
            if ($key == $number)
            {
                return $value;
            }
            elseif ($key > $number)
            {
                return $value + ($value1 - $value) * ($key - $number) / ($key - $key1);
            }
            else
            {
                $key1 = $key;
                $value1 = $value;
            }
    }

    /**
     * @Route("/calculator", name="calculator")
     */
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('type', ChoiceType::class, [
                'choices' => [
                    '1.1 І рівня електрифікації - в будинках з плитами на природному газі' => 11,
                    '1.2 ІІ рівня електрифікації - в будинках з плитами на скрапленому газі та на твердому паливі' => 12,
                    '1.3 ІІІ рівня електрифікації - в будинках з електроплитами потужністю до 8,5 кВт вкл.' => 13,
                    '1.4 ІV рівня електрифікації - в будинках з електроплитами потужністю до 10,5 кВт вкл.' => 14,
                    '1.5 V рівня електрифікації - в будиночках на ділянках садівничих товариств' => 15,
                    '2.1 І рівня електрифікації - в будинках з плитами на природному газі' => 21,
                    '2.2 ІІ рівня електрифікації - в будинках з електроплитами потужністю до 10,5 кВт вкл.' => 22,
                ],
                'group_by' => function($choice, $key, $value) {
                    if ($value < 20) {
                        return 'Житла 1-го виду:';
                    } else {
                        return 'Житла 2-го виду:';
                    }
                },
                'label' => 'Виберіть вид житла:',
            ])
            ->add('number', IntegerType::class, ['label' => 'Кількість жител:'])
            ->add('save', SubmitType::class, ['label' => 'Порахувати'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $type = $form->getData()['type'];
            $number = $form->getData()['number'];

            $result = $this->calc($type, $number);

            return $this->render('calculator/result.html.twig', [
                'form' => $form->createView(),
                'result' => $result,
                'number' => $number,
            ]);
        }

        return $this->render('calculator/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
