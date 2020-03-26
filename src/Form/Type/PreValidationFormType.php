<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PreValidationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('family_name', TextType::class)
            ->add('given_name', TextType::class)
            ->add('birth_date', BirthdayType::class,['format' => 'dd-MM-yyyy',])
            ->add('document_type', CollectionType::class, [
                'label' => 'document_type',
                'entry_type' => CollectionDocumentTypeFormType::class,
                'entry_options'=>['label'=>false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => array(
                    'class' => 'document_type',
                ),
                'help'=> 'Used to restrict the type of accepted IDs. Value(s) can be id_card:fra for French ID cards, passport:* for passports. Don\'t forget to replace * 
                with the three-letter country code corresponding to the accepted country. If you accept all European passports, replace * with eu. View the list of ISO 3166-1 alpha-3 codes'
            ])
            ->add('cni1', FileType::class,[
                'required' => true,
                'attr' => array(
                    'onchange' => 'loadFileName(this)',
                    'accept' => 'application/pdf,application/x-pdf,image/x-png,image/jpeg'
                ),
            ])
            ->add('cni2', FileType::class,[
                'required' => false,
                'attr' => array(
                    'onchange' => 'loadFileName(this)',
                    'accept' => 'application/pdf,application/x-pdf,image/x-png,image/jpeg'
                ),
                ])
            ->add('profile', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'medium' => 'medium',
                    'high' => 'high',
                ],
                'help'=>'profile determines the type of certificate that can be issued with the provided identity document. Set the value to medium if you require a standard
                 certificate (used for level 2 signature transactions) or high if you require a qualified certificate (used for level 3 signature transactions)'
            ])
            ->add('color_required',CheckboxType::class,[
                'required' => false,
                'help' => 'If you require a color document, set the value to true. If you set the profile to high DO NOT set the value to false or you will be returned a 400 error.'
                ])
            ->add('expires_after', BirthdayType::class,[
                'required' => false,
                'format' => 'dd-MM-yyyy',
                'help' => 'The date after which the ID is allowed to be expired. This parameter is used to indicate whether an ID is accepted even if expired since less
                 than 2 years, if an ID must be valid on prevalidation date or if it must be valid at a specific later date.'
                ])
         ;


    }

    public function getBlockPrefix():string
    {
        return 'PreValidationFormType';
    }
}