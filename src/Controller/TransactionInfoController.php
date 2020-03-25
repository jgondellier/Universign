<?php

namespace App\Controller;

use Gondellier\UniversignBundle\Service\TransactionInfoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionInfoController extends AbstractController
{
    /**
     * @Route("/transactioninfo/{id}", name="transactioninfo")
     * @param Request $request
     * @param null $id
     * @return Response
     */
    public function tansactionInfo(Request $request, $id = null): Response
    {
        $defaultData = ['send' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('id', TextType::class)
            ->add('type', ChoiceType::class,[
                'required'   => false,
                'choices' => [
                    'id' => '',
                    'customId' => 'customId'
                ],
            ])
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if (($form->isSubmitted() && $form->isValid()) || $id !== null) {
            $data = $form->getData();
            if ($id === null) {
                $id = $data['id'];
            }
            $transactionInfoService = new TransactionInfoService($this->getParameter('univ.uri'));
            if(array_key_exists('type',$data) && $data['type'] === 'customId'){
                $transactionInfoService->getTransactionInfoByCustomID($id);
            }else{
                $transactionInfoService->getTransactionInfo($id);
            }

            return $this->render('transactioninfo.html.twig', [
                'form' => $form->createView(),
                'service' => $transactionInfoService,
                'originalResult' => $transactionInfoService->getOriginalResult(),
            ]);
        }

        return $this->render('transactioninfo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}