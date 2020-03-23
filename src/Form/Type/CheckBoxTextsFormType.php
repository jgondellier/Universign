<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CheckBoxTextsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('checkBoxTexts', TextType::class, [
                'label' => false,
                'attr' => array(
                    'class' => 'checkBoxTexts',
                ),
            ])
        ;
    }
    public function getBlockPrefix()
    {
        return 'CheckBoxTextsFormType';
    }
}