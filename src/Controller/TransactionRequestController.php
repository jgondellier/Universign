<?php

namespace App\Controller;

use App\Form\Type\DocSignatureFormType;
use App\Form\Type\DocumentFormType;
use App\Form\Type\TransactionRequestFormType;
use App\Form\Type\TransactionSignerFormType;
use App\Util\DataTool;
use App\Util\DocSignatureFieldDataTool;
use App\Util\TransactionDocumentDataTool;
use App\Util\TransactionRequestDataTool;
use App\Util\TransactionSignerDataTool;
use Gondellier\UniversignBundle\Classes\Request\TransactionRequest;
use Gondellier\UniversignBundle\Service\TransactionRequestService;
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
            ->add('transactionrequest',TransactionRequestFormType::class,['label' => false,])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            var_dump($data);
            $docSignatureFieldDatTool = new DocSignatureFieldDataTool();
            $transactionSignerDataTool = new TransactionSignerDataTool();
            $transactionDocumentDataTool = new TransactionDocumentDataTool();
            $transactionRequestDataTool = new TransactionRequestDataTool;
            $transactionSigner = $transactionSignerDataTool->setData($data);
            $docSignatureField = $docSignatureFieldDatTool->setData($data);
            $transactionDocument = $transactionDocumentDataTool->setData($data);
            $transactionDocument->setSignatureFields($docSignatureField);
            $transactionRequest = $transactionRequestDataTool->setData($data);
            $transactionRequest->setSigners($transactionSigner);
            $transactionRequest->setDocuments($transactionDocument);
            var_dump($transactionRequest);

            $transactionRequestService = new TransactionRequestService($this->getParameter('univ.uri'));
            $transactionRequestService->validate($transactionRequest);

            return $this->render('universign/transactionrequest.html.twig', [
                'form' => $form->createView(),
                'originalResult' => $transactionRequestService->getOriginalResult(),
                'service' => $transactionRequestService
            ]);
        }

        return $this->render('universign/transactionrequest.html.twig', [
            'form' => $form->createView()
        ]);
    }
}