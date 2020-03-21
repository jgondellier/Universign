<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class DocSignaturesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('docsignature', CollectionType::class, [
                'label' => 'Configuration des signature sur le document :',
                'entry_type' => DocSignatureFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => array(
                    'class' => 'docsignature',
                ),
            ])
        ;
    }
    public function getBlockPrefix()
    {
        return 'DocSignaturesFormType';
    }
}