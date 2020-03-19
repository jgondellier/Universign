<?php

namespace App\Form\Type;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

class SepaDataFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rum', TextType::class,[
                'required'   => false,
                'help' => 'A unique mandate identifier.'
            ])
            ->add('ics', TextType::class,[
                'required'   => false,
                'help' => 'A unique creditor identifier.'
            ])
            ->add('iban', TextType::class,[
                'required'   => false,
                'help' => 'The debtor International Bank Account Number.'
            ])
            ->add('bic', TextType::class,[
                'required'   => false,
                'help' => 'The debtor Bank Identifier Code.'
            ])
            ->add('recurring', Boolean::class,[
                'required'   => false,
                'help' => 'Whether this SEPA mandate describe a recurring payment (true) or a single-shot payement (false).'
            ])
            ->add('debtor', SepaDataThirdPartyFormType::class,[
                'required'   => false,
                'help' => 'Information on the debtor.'
            ])
            ->add('creditor', SepaDataThirdPartyFormType::class,[
                'required'   => false,
                'help' => 'Information on the creaditor'
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sepa_data';
    }
}