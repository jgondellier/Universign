<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ListCheckBoxTextsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('listcheckBoxTexts', CollectionType::class, [
                'label' => 'checkBoxTexts',
                'entry_type' => CheckBoxTextsFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => array(
                    'class' => 'listcheckBoxTexts',
                ),
            ])
        ;
    }
    public function getBlockPrefix()
    {
        return 'ListCheckBoxTextsFormType';
    }
}