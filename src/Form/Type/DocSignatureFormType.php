<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocSignatureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('name', TextType::class,['required' => false,])
            ->add('page', IntegerType::class,['required' => false,])
            ->add('x', IntegerType::class,['required' => false,])
            ->add('y', IntegerType::class,['required' => false,])
            ->add('signerIndex', IntegerType::class,['required' => false,])
            ->add('patternName',TextType::class,['required' => false,])
            ->add('label',TextType::class,['required' => false,])
        ;
    }

    public function getBlockPrefix():string
    {
        return 'docSignatureFormType';
    }
}