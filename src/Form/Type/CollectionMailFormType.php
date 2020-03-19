<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CollectionMailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mail', TextType::class, [
                'required' => false,
                'label'    => 'Mail',
            ])
        ;
    }
    public function getBlockPrefix()
    {
        return 'CollectionMailFormType';
    }
}