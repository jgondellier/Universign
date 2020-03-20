<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

class RedirectionConfigFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('URL', UrlType::class,[
                'required'   => false,
                ])
            ->add('displayName', TextType::class,[
                    'required'   => false,
            ]);
    }

    public function getBlockPrefix(): string
    {
        return 'RedirectionConfigFormType';
    }
}