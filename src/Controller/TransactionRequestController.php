<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class TransactionRequestController extends AbstractController
{
    /**
     * @Route("/universign/transactionrequest", name="transactionrequest")
     * @param Request $request
     * @return Response
     */
    public function transactionrequest(Request $request): Response
    {
        $defaultData = ['send' => ''];
        $form = $this->createFormBuilder($defaultData)
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
            ->add('cni1', FileType::class, ['required' => false])
            ->add('cni2', FileType::class, ['required' => false])
            ->add('certificateType', ChoiceType::class, [
                'choices' => [
                    'simple' => 'simple',
                    'certified' => 'certified',
                    'advanced' => 'advanced',
                ],
                'attr' => array(
                    'onchange' => 'changeCertificateTypeChoice()',
                ),
                'data' => 'certified',
            ])
            ->add('validationSessionId', TextType::class, [
                'required' => false
            ])
            ->add('email', EmailType::class)
            ->add('mobile', TelType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 10, 'max' => 10])]
            ])
            ->add('send', SubmitType::class)
            ->add('readDocuments', CollectionType::class, [
                    'label' => 'Documents a lire',
                    'entry_type' => FileType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
            ->add('signDocuments', CollectionType::class, [
                    'label' => 'Documents a signer',
                    'entry_type' => FileType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
        }

        return $this->render('universign/transactionrequest.html.twig', [
            'form' => $form->createView()
        ]);
    }
}