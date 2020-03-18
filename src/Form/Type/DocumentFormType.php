<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('document', FileType::class, [
                'required' => false,
                'label'    => 'Document',
                'attr' => array(
                    'onchange' => 'loadFileName(this)',
                ),
            ])
        ;
    }
    public function getBlockPrefix()
    {
        return 'DocumentFormType';
    }
}