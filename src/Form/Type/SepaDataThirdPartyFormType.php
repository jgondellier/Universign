<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

class SepaDataThirdPartyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'required'   => false,
                'help' => 'The full name of this debtor/creditor.'
            ])
            ->add('address', TextType::class,[
                'required'   => false,
                'help' => 'The address of this debtor/creditor.'
            ])
            ->add('postalCode', TextType::class,[
                'required'   => false,
                'help' => 'The postal code of this debtor/creditor.'
            ])
            ->add('city', TextType::class,[
                'required'   => false,
                'help' => 'The city of this debtor/creditor'
            ])
            ->add('country', TextType::class,[
                'required'   => false,
                'help' => 'The country of this debtor/creditor.'
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sepa_data_third_party';
    }
}