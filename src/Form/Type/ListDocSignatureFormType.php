<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class ListDocSignatureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('name', CollectionType::class, [
                'label' => 'Option du cartouche de signature',
                'entry_type' => DocSignatureFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => array(
                    'class' => 'conf-doc-sign',
                )
            ])
        ;
    }

    public function getBlockPrefix():string
    {
        return 'ListDocSignatureFormType';
    }
}