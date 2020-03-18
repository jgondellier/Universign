<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TransactionRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('profile', TextType::class)
            ->add('customId', TextType::class)
            ->add('mustContactFirstSigner', CheckboxType::class)
            ->add('finalDocSent', CheckboxType::class)
            ->add('finalDocRequesterSent', CheckboxType::class)
            ->add('finalDocObserverSent', CheckboxType::class)
            ->add('description', TextType::class)
            ->add('certificateType', ChoiceType::class, [
                'choices' => [
                    'simple' => 'simple',
                    'certified' => 'certified',
                    'advanced' => 'advanced',
                ],
                'empty_data' => 'certified'
            ])
            ->add('language', ChoiceType::class, [
                'choices' => [
                    'Bulgarian' => 'bg',
                    'Catalan' => 'ca',
                    'German' => 'de',
                    'English' => 'en',
                    'Spanish' => 'es',
                    'French' => 'fr',
                    'Italian' => 'it',
                    'Dutch' => 'nl',
                    'Polish' => 'pl',
                    'Portuguese' => 'pt',
                    'Romanian' => 'ro',
                ],
                'empty_data' => 'fr'
            ])
            ->add('handwrittenSignatureMode', ChoiceType::class, [
                'choices' => [
                    'disables the hand-written signature' => 0,
                    'enables the hand-written signature' => 1,
                    'enables the hand-written signature if only it is a touch interface' => 2,
                ],
                'empty_data' => 0
            ])
            ->add('chainingMode', ChoiceType::class, [
                'choices' => [
                    'No invitation email is sent in this mode' => 'none',
                    'The signersr receive the invitation email' => 'email',
                    'All signers are physically at the same place.' => 'web',
                ],
                'empty_data' => 'web'
            ])
            ->add('finalDocCCeMails', CollectionType::class, [
                'label' => false,
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => array(
                    'class' => 'finalDocCCeMails',
                )
            ])
            ->add('autoValidationRedirection', RedirectionConfigFormType::class)
            ->add('redirectPolicy', ChoiceType::class, [
                'choices' => [
                    'The redirection page displays the signed pages.' => 'dashboard',
                    'The redirection page does not display the signed pages.' => 'quick',
                ],
                'empty_data' => 'dashboard'
            ])
            ->add('redirectWait', IntegerType::class)
            ->add('autoSendAgreements', CheckboxType::class)
            ->add('operator', TextType::class)
            ->add('registrationCallbackURL', TextType::class)
            ->add('successRedirection', RedirectionConfigFormType::class)
            ->add('cancelRedirection', RedirectionConfigFormType::class)
            ->add('failRedirection', RedirectionConfigFormType::class)
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'tansaction_request';
    }
}