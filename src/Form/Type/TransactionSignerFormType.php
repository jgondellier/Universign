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
            ->add('lastname', TextType::class, [
                'required' =>  false,
                'help' => 'This signer’s lastname. Note that this field is mandatory for a self-signed certificate. When using validationSessionId, it must be set to the same value than the one used in the validation request.'
                ])
            ->add('firstname', TextType::class, [
                'required' =>  false,
                'help' => 'This signer’s firstname. Note that this field is mandatory for a self-signed certificate. When using validationSessionId, it must be set to the same value than the one used in the validation request.'
                ])
            ->add('birthdate', BirthdayType::class, [
                'format' => 'dd-MM-yyyy',
                'required' =>  false,
                'help' => 'This signer’s birth date. This is an option for the certified signature, if it’s set, the user won’t be asked to provide it’s birth date during the RA workflow. When using validationSessionId, it must be set to the same value than the one used in the validation request.'
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'carte nationale d’identité' => 'id_card_fr',
                    'passeport' => 'passport_eu',
                    'permis de séjour' => 'titre_sejour',
                    'permis de conduire Européen' => 'drive_license',
                ],
                'help' => 'The type of the provided ID documents.
id_card_fr French ID card. Two ID documents should be provided.
passport_eu French Passport. Only one ID document should be provided.
titre_sejour Residence Permit. Two ID documents should be provided.'
            ])
            ->add('cni1', FileType::class, [
                'required' => false,
                'attr' => array(
                    'onchange' => 'loadFileName(this)',
                ),
                'help' => ''
                ])
            ->add('cni2', FileType::class, [
                'required' => false,
                'attr' => array(
                    'onchange' => 'loadFileName(this)',
                ),
                'help' => ''
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
                'help' => 'Indicates which certificate type will be used to perform the signature and therefore which type of signature will be performed by this signer.
                The available values are: certified Allows signers to perform a certified signature. 
                advanced Allows signers to perform an advanced signature which requires the same options as a certified signature.
                simple Allows signers to perform a simple signature.The default value.'
            ])
            ->add('validationSessionId', TextType::class, [
                'required' => false,
                'help' => 'from a validation request (see universign-guide-8.18-SNAPSHOT-ra.pdf). The documents in this ID Validation session will be used and no need to provide idDocuments.'
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'help' => 'This signer’s e-mail address. Note that all users except the first
must have an email address set. The first user must have one if
he has to be contacted by e-mail, e.g. for authentication or if the
mustContactFirstSigner parameter of TransactionRequest is
set to true.'
            ])
            ->add('mobile', TelType::class, [
                'required' => true,
                'constraints' => [],
                'help' => 'This signer’s mobile phone number that should be written in the
international format: the country code followed by the phone
number (for example, in France 33 XXXXXXXXX).'
            ])
            ->add('invitationMessage', TextType::class, [
                'required' => false,
                'help' => 'A custom message added to the invitation email for signing for every signer.'
            ])
            ->add('organization', TextType::class, [
                'required' => false,
                'help' => 'This signer’s organization.'
            ])
            ->add('universignId', TextType::class, [
                'required' => false,
                'help' => 'An external identifier given by the organization that indicates this signer. successRedirection [O] RedirectionConfig The configuration of the signer'
            ])
            ->add('profile', TextType::class, [
                'required' => false,
                'help' => 'The name of the signer profile to use for some customizations. It is set up by the UNIVERSIGN team.'
            ])
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'signer' => 'signer',
                    'observer' => 'observer',
                ],
                'help' => 'The role of this transaction actor signer (default) This actor is a signer and he will be able to view the documents and sign them. observer This actor is an observer and he will'
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
                'empty_data' => 'fr',
                'preferred_choices' => ['fr','en'],
                'help' =>'The language for the signer’s transaction.',
            ])
            ->add('successRedirection', RedirectionConfigFormType::class,[
                'required'   => false,
                'help' =>'The configuration of the signer redirection in the event that the signing process is successfully completed.'
            ])
            ->add('cancelRedirection', RedirectionConfigFormType::class,[
                'required'   => false,
                'help' =>'The configuration of the signer redirection in the event that the signing process is canceled.'
            ])
            ->add('failRedirection', RedirectionConfigFormType::class,[
                'required'   => false,
                'help' =>'The configuration of the signer redirection in the event that the signing process fails.'
            ])
            ;
    }

    public function getBlockPrefix():string
    {
        return 'TransactionSignerFormType';
    }
}