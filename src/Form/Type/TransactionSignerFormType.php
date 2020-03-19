<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TransactionSignerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('birthdate', BirthdayType::class, ['format' => 'dd-MM-yyyy',])
            ->add('prevalCNI', CheckboxType::class, [
                'label' => 'Pièce d\'identité déja validée ?',
                'required' => false,
                'attr' => array(
                    'onchange' => 'changePrevalChoice()',
                ),
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'carte nationale d’identité' => 'id_card_fr',
                    'passeport' => 'passport_eu',
                    'permis de séjour' => 'titre_sejour',
                    'permis de conduire Européen' => 'drive_license',
                ]])
            ->add('cni1', FileType::class, [
                'required' => false,
                'attr' => array(
                    'onchange' => 'loadFileName(this)',
                ),
                ])
            ->add('cni2', FileType::class, [
                'required' => false,
                'attr' => array(
                    'onchange' => 'loadFileName(this)',
                ),
                ])
            ->add('certificateType', ChoiceType::class, [
                'choices' => [
                    'simple' => 'simple',
                    'certified' => 'certified',
                    'advanced' => 'advanced',
                ],
                'attr' => array(
                    'onchange' => 'changeCertificateTypeChoice(this)',
                ),
                'empty_data' => 'certified',
                'preferred_choices' => ['certified'],
            ])
            ->add('validationSessionId', TextType::class, [
                'required' => false
            ])
            ->add('email', EmailType::class)
            ->add('mobile', TelType::class, [
                'required' => true,
                'constraints' => []
            ])
            ;
    }

    public function getBlockPrefix():string
    {
        return 'tansaction_signer';
    }
}