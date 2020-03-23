<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class DocumentsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('documents', CollectionType::class, [
                'label' => false,
                'entry_type' => TransactionDocumentFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => array(
                    'class' => 'documents',
                ),
            ])
        ;
    }
    public function getBlockPrefix():string
    {
        return 'DocumentsFormType';
    }
}