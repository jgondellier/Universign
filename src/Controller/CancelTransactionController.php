<?php

namespace App\Controller;

use Gondellier\UniversignBundle\Service\TransactionInfoService;
use Gondellier\UniversignBundle\Service\TransactionRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CancelTransactionController extends AbstractController
{
    /**
     * @Route("/relaunchtransaction/{id}", name="transactioninfo")
     * @param Request $request
     * @param null $id
     * @return Response
     */
    public function cancelTransaction(Request $request, $id = null): Response
    {
        $defaultData = ['send' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('id', TextType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if (($form->isSubmitted() && $form->isValid()) || $id !== null) {
            $data = $form->getData();
            if ($id === null) {
                $id = $data['id'];
            }
            $transactionRequestService = new TransactionRequestService($this->getParameter('univ.uri'));
            $transactionRequestService->cancelTransaction($id);

            return $this->render('Transaction/CancelTransaction.html.twig', [
                'form' => $form->createView(),
                'service' => $transactionRequestService,
                'originalResult' => $transactionRequestService->getOriginalResult(),
            ]);
        }

        return $this->render('Transaction/CancelTransaction.html.twig', [
            'form' => $form->createView()
        ]);
    }
}