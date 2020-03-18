<?php

namespace App\Controller;

use App\Form\Type\DocSignatureFormType;
use App\Form\Type\DocumentFormType;
use App\Form\Type\TransactionRequestFormType;
use App\Form\Type\TransactionSignerFormType;
use App\Util\DataTool;
use Gondellier\UniversignBundle\Classes\Request\TransactionRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
            ->add('signer',TransactionSignerFormType::class)
            ->add('send', SubmitType::class)
            ->add('readDocuments', CollectionType::class, [
                'label' => 'Documents à lire',
                'entry_type' => DocumentFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => array(
                    'class' => 'read-documents',
                )
            ])
            ->add('signDocuments', CollectionType::class, [
                    'label' => 'Documents à signer',
                    'entry_type' => DocumentFormType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'attr' => array(
                        'class' => 'sign-documents',
                    ),
                ]
            )
            ->add('confdocsign', CollectionType::class, [
                    'label' => 'Option du cartouche de signature',
                    'entry_type' => DocSignatureFormType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'attr' => array(
                        'class' => 'conf-doc-sign',
                    ),
                ]
            )
            ->add('confsign',TransactionRequestFormType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $dataTool = new DataTool();
            $transactionSigner = $dataTool->setSigner($data);
            $docSignatureField = $dataTool->setDocSignatureField($data);
            $transactionDocument = $dataTool->setTransactionDocument($data);
            $transactionDocument->setSignatureFields($docSignatureField);
            $transactionRequest = new TransactionRequest();
            $transactionRequest->setProfile();
            $transactionRequest->setCustomId();
            $transactionRequest->setMustContactFirstSigner();
            $transactionRequest->setFinalDocRequesterSent();
            $transactionRequest->setFinalDocSent();
            $transactionRequest->setFinalDocObserverSent();
            $transactionRequest->setDescription();
            $transactionRequest->setCertificateType();
            $transactionRequest->setLanguage('fr');
            $transactionRequest->setHandwrittenSignatureMode(0);
            $transactionRequest->setChainingMode('web');
            $transactionRequest->setSigners($transactionSigner);
            $transactionRequest->setDocuments($transactionDocument);
            $transactionRequest->setFinalDocCCeMails();
            $transactionRequest->setAutoValidationURL();
            $transactionRequest->setRedirectPolicy();
            $transactionRequest->setRedirectWait();
            $transactionRequest->setAutoSendAgreements();
            $transactionRequest->setOperator();
            $transactionRequest->setRegistrationCallbackURL();

            var_dump($data);exit;
        }

        return $this->render('universign/transactionrequest.html.twig', [
            'form' => $form->createView()
        ]);
    }
}