<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class SignersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('signers', CollectionType::class, [
                'label' => false,
                'entry_type' => TransactionSignerFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => array(
                    'class' => 'signers',
                ),
            ])
        ;
    }
    public function getBlockPrefix()
    {
        return 'SignersFormType';
    }
}