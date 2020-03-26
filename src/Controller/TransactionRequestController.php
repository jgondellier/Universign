<?php

namespace App\Controller;

use App\Form\Type\TransactionRequestFormType;
use App\Util\TransactionDocumentDataTool;
use App\Util\TransactionRequestDataTool;
use App\Util\TransactionSignerDataTool;
use Gondellier\UniversignBundle\Service\TransactionRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionRequestController extends AbstractController
{
    /**
     * @Route("/transactionrequest", name="transactionrequest")
     * @param Request $request
     * @return Response
     */
    public function transactionrequest(Request $request): Response
    {
        $defaultData = ['send' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('transactionrequest', TransactionRequestFormType::class, ['label' => false,])
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $transactionSignerDataTool = new TransactionSignerDataTool();
            $transactionDocumentDataTool = new TransactionDocumentDataTool();
            $transactionRequestDataTool = new TransactionRequestDataTool;
            $transactionDocuments = $transactionDocumentDataTool->setData($data['transactionrequest']['documents']['documents']);
            $transactionRequest = $transactionRequestDataTool->setData($data['transactionrequest']);
            foreach ($data['transactionrequest']['signers']['signers'] as $signer){
                $transactionSigner = $transactionSignerDataTool->setData($signer);
                $transactionRequest->addSigner($transactionSigner);
            }
            $transactionRequest->setDocuments($transactionDocuments);

            $transactionRequestService = new TransactionRequestService($this->getParameter('univ.uri'));
            $transactionRequestService->validate($transactionRequest);

            return $this->render('transactionrequest.html.twig', [
                'form' => $form->createView(),
                'originalResult' => $transactionRequestService->getOriginalResult(),
                'service' => $transactionRequestService
            ]);
        }

        return $this->render('transactionrequest.html.twig', [
            'form' => $form->createView()
        ]);
    }
}