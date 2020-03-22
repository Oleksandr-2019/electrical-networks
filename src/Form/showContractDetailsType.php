<?php
// src/Form/showContractDetailsType.php
namespace App\Form;

use App\Entity\ContractDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class showContractDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contractNumber', NumberType::class, [
                'label' => 'Номер договору',
                'required' => false,
            ])
            ->add('nameContract', TextType::class,[
                'label' => "Назва договору",
                'required' => false,
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContractDetails::class,
        ]);
    }
}
