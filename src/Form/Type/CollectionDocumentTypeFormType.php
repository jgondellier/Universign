<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CollectionDocumentTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('document_type', ChoiceType::class, [
                'choices' => [
                    'Carte nationale d’identité' => 'id_card:fra',
                    'Passeport europe' => 'passport:eu',
                    'Passeport francais' => 'passport:fra',
                    'Passeport espagnole' => 'passport:esp',
                    'Passeport italien' => 'passport:ita',
                ],
                'required' => false,
                'label'    => 'document_type',
            ])
        ;
    }
    public function getBlockPrefix():string
    {
        return 'CollectionDocumentTypeFormType';
    }
}