<?php


// src/Form/SchemesTpType.php
namespace App\Form;

use App\Entity\SchemesTp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SchemesTpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // поле додавання файлу
            ->add('schemeTp', FileType::class, [
                'label' => 'Схема трансформаторної підстанції (jpg формат)',

                // unmapped означає, що це поле не пов'язане з будь-якою власністю сутності
                'mapped' => false,

                //зробіть це необов’язковим, тому вам не доведеться повторно завантажувати PDF-файл
                // щоразу, коли ви редагуєте деталі продукту
                'required' => false,

                // unmapped поля не можуть визначити їх перевірку за допомогою приміток
                // в асоційованому об'єкті, тому ви можете використовувати класи обмежень PHP
                'constraints' => [
                    new File([
                        'maxSize' => '10240k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/x-jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid "jpg" document',
                    ])
                ],

            ])
            ->add('numberTP', NumberType::class, [
                'label' => "Введіть номер підстанції"
            ])
            ->add('descriptionTP', TextType::class, [
                'label' => "Введіть додаткові відмості"
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SchemesTp::class,
        ]);
    }
}