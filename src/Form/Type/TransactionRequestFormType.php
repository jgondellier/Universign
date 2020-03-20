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
            ->add('profile', TextType::class,[
                'required' => false,
                'help'=>'The name of the signature profile to use. Signature profiles mainly differ by the displayed company name and logo, and the pre-configured signature field stored
                within. Signature profiles are set up by the UNIVERSIGN team. The default value is default.'
                ])
            ->add('customId', TextType::class,[
                'required' => false,
                'help' => 'A requester-set unique id that can be used to identify this transaction. If not unique, a fault will be thrown. Note that UNIVERSIGN generate its own unique id for
                each transaction and return it to the requester'
            ])
            ->add('signers', SignersFormType::class, [
                'label' => false,
                'attr' => array(
                    'class' => 'signers',
                ),
                'help' => 'The signers that will have to take part to the transaction.Must contain at least one element.'
            ])
            ->add('documents', DocumentsFormType::class,[
                'required'   => false,
                'attr' => array(
                    'class' => 'documents',
                ),
                'help' => 'The documents to be signed. Must contain at least one element. The size limit of each document is set to 10MB.'
            ])
            ->add('mustContactFirstSigner', CheckboxType::class,[
                'required'   => false,
                'help' => 'If set to True, the first signer will receive an invitation to sign the document(s) by e-mail as soon as the transaction is requested. False by default.'
            ])
            ->add('finalDocSent', CheckboxType::class,[
                'required'   => false,
                'help' => 'Tells whether each signer must receive the signed documents by e-mail when the transaction is completed. False by default.'
            ])
            ->add('finalDocRequesterSent', CheckboxType::class,[
                'required'   => false,
                'help' =>'Tells whether the requester must receive the signed documents via e-mail when the transaction is completed. False by default.'
            ])
            ->add('finalDocObserverSent', CheckboxType::class,[
                'required'   => false,
                'help' =>'Tells whether the observers must receive the signed documents via e-mail when the transaction is completed. It takes the finalDocSent value by default.'
            ])
            ->add('description', TextType::class,[
                'required'   => false,
                'help' =>'Description or title of the signature.'
            ])
            ->add('certificateType', ChoiceType::class, [
                'choices' => [
                    'simple' => 'simple',
                    'certified' => 'certified',
                    'advanced' => 'advanced',
                ],
                'empty_data' => 'certified',
                'preferred_choices' => ['certified'],
                'help' =>'Option that indicates which certificate type will be used to perform the signature (and therefore which type of signature is expected).'
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
                'help' =>'The interface language for this transaction.',
            ])
            ->add('handwrittenSignatureMode', ChoiceType::class, [
                'choices' => [
                    'disables the hand-written signature' => 0,
                    'enables the hand-written signature' => 1,
                    'enables the hand-written signature if only it is a touch interface' => 2,
                ],
                'empty_data' => 0,
                'help' =>'The mode to enable the handwritten signature. If handwritten signature is enabled, the signer is prompted to draw a signature on the web interface and the
                SignatureField bean becomes mandatory for each of the TransactionSigners. This signature is added in his signature field, as an image would be.
                HandwrittenSignatureMode can not be enabled against a transaction containing only document for presentation.',
            ])
            ->add('chainingMode', ChoiceType::class, [
                'choices' => [
                    'No invitation email is sent in this mode' => 'none',
                    'The signersr receive the invitation email' => 'email',
                    'All signers are physically at the same place.' => 'web',
                ],
                'empty_data' => 'web',
                'help' =>'This option indicates how the signers are chained during the signing process.',
            ])
            ->add('finalDocCCeMails', CollectionType::class, [
                'label' => 'Mail en copie',
                'entry_type' => CollectionMailFormType::class,
                'entry_options'=>['label'=>false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => array(
                    'class' => 'finalDocCCeMails',
                ),
                'help' =>'This option allows to send a copy of the final signed documents to a list of email addresses (finalDocSent must be sent to True.)',
            ])
            ->add('autoValidationRedirection', RedirectionConfigFormType::class, [
                'help' =>'The configuration of the signer redirection in the event that an advanced signature is interrupted after the automatic validation step.',
            ])
            ->add('redirectPolicy', ChoiceType::class, [
                'choices' => [
                    'The redirection page displays the signed pages.' => 'dashboard',
                    'The redirection page does not display the signed pages.' => 'quick',
                ],
                'empty_data' => 'dashboard',
                'help' =>'This option allow to customize the way signers are redirect after signing documents.This field can be overridden in TransactionSigner for a specific signer.'
            ])
            ->add('redirectWait', IntegerType::class,[
                'required'   => false,
                'help' =>'The waiting time in seconds for signers to be redirected if redirectPolicy is dashboard.The lower bound is "2", the upper bound is "30" and default value is "5".'
            ])
            ->add('autoSendAgreements', CheckboxType::class,[
                'required'   => false,
                'help' =>'Whether the subscription agreements email should be automatically sent to signers. If set to false, the email will be sent by the transaction’s operator himself.
                This field can be overridden in TransactionSigner for a specific signer.'
            ])
            ->add('operator', TextType::class,[
                'required'   => false,
                'help' =>'The default registration authority operator email address. This field is used only for advanced transactions. This address must match with a wellknown registration
                authority operator by Universign. It is only used to send the transaction creation email. If not specified, the email is sent to the transaction creator.'
            ])
            ->add('registrationCallbackURL', TextType::class,[
                'required'   => false,
                'help' =>'The callback URL to be requested when the RA validation is completed. This field is used only for advanced transactions.'
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

    public function getBlockPrefix(): string
    {
        return 'TransactionRequestFormType';
    }
}