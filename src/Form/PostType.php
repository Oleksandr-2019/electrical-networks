<?php


// src/Form/PostType.php
namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // поле додавання головного зображення посту
            ->add('nameMainImagePost', FileType::class, [
                'label' => 'Головне зображення новини (jpg формат)',

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
            // поле додавання заголовку посту
            ->add('titlePost', TextType::class, [
                'label' => "Введіть заголовок новини"
            ])
            // поле додавання текстової частини
            ->add('textPost', TextareaType::class, [
                'label' => "Введіть текстовий опис новини"
            ])
            ->add('Зберегти', SubmitType::class);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}