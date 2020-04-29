<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ValidationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('birthdate', BirthdayType::class,['format' => 'dd-MM-yyyy',])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'carte nationale d’identité' => 0,
                    'passeport' => 1,
                    'permis de séjour' => 2,
                    'permis de conduire Européen' => 3,
                ]])
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
            ->add('allowManual', CheckboxType::class,[
                'required'   => false,
                'help' =>'Whether to allow manual validation or not.'
            ])
            ->add('callbackURL', TextType::class,[
                'required'   => false,
                'help' =>'The callback URL to be requested, once the validation session is completed (i.e. its status is VALID or INVALID).
                 A GET request will be performed with following parameters appended to the URL:
                    id : Validation session identifier.
                    status : Validation session status. See ValidatorResult.
                    Example: http://www.company.com/vs?id=123-abc&status=1'
            ])
         ;


    }

    public function getBlockPrefix():string
    {
        return 'ValidationFormType';
    }
}