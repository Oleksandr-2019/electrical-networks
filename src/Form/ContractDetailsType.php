<?php
// src/Form/ContractDetailsType.php
namespace App\Form;

use App\Entity\ContractDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContractDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // поле додавання файлу
            ->add('contractNumber', NumberType::class, [
                'label' => 'Номер договору',
            ])
            ->add('nameContract', TextType::class,[
                'label' => "Назва договору"
            ])
            ->add('telephoneNumbers', CollectionType::class, [
                'label' => 'Перелік існуючих номерів',
                'entry_type' => TextType::class,
                'allow_add' => true,//дає можливість добавлять нові номери вже до існуючих
                'prototype' => true,
                'prototype_data' => false,//Placeholder для поля полів додавання нових номерів
                'prototype_name' => 'contacts',//тільки з цим запрацювала можливість добавлять нові номери вже до існуючих так як слово contacts використовується в коді jquery - contacts в цьому може бути будьяким іншим словом
                'entry_options' => [
                    'label' =>  false,//якщо задать якусь строку то вона зявиться біля кожного поля input
                ],
                'allow_delete' => true,//можливысть видалення даних
                'delete_empty' => true,//видалення пустих елементів масива
                'required' => false,//робить добавляння нового значення кожного розу не обовязковив - корисно наприклад коли треба просто удалить щось а добавлять не треба
                'row_attr' => ['class' => 'realTelNumbersWrap', 'id' => '...'],//Встановлює атрибути HTML для загального div єлемента
                /*

                                'help' => 'The ZIP/Postal code for your credit card\'s billing address.',//задає текстовку для поля яке іде одразу після інпутів цього типу
                                'help_html' => true,//За замовчуванням вміст help опції залишається перед виведенням їх у шаблон. Встановіть цей параметр, щоб true не уникати їх, що корисно, коли довідка містить елементи HTML.
                                'help_attr' => ['class' => 'CUSTOM_LABEL_CLASS_for_help'],//Встановлює атрибути HTML для елемента, який використовується для відображення довідкового повідомлення поля форми. Його значення - асоціативний масив з іменами атрибутів HTML як ключі. Ці атрибути також можна встановити в шаблоні
                                'attr' => ['class' => 'all_my_cotacts'],//унікальний ідентифікатор - наприклад для використання в CSS або в JS
                                'label_attr' => ['class' => 'CUSTOM_LABEL_CLASS'],//Встановлює атрибути HTML для <label>елемента, який буде використаний під час надання мітки для поля
                                'row_attr' => ['class' => 'text-editor', 'id' => '...'],//Встановлює атрибути HTML для загального div єлемента

                */

            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContractDetails::class,
        ]);
    }
}