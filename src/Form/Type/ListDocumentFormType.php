<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class ListDocumentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('listDocument', CollectionType::class, [
                'label' => false,
                'entry_type' => DocumentFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => array(
                    'class' => 'documents',
                )
            ])
        ;
    }
    public function getBlockPrefix()
    {
        return 'DocumentType';
    }
}