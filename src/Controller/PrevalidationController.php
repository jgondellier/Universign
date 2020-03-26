<?php

namespace App\Controller;

use App\Form\Type\PreValidationFormType;
use App\Form\Type\TransactionRequestFormType;
use App\Form\Type\ValidationFormType;
use App\Util\PrevalidationDataTool;
use Gondellier\UniversignBundle\Service\GetDocumentsService;
use Gondellier\UniversignBundle\Service\PrevalidationRequestService;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrevalidationController extends AbstractController
{
    /**
     * @Route("/prevalidation", name="prevalidation")
     * @param Request $request
     * @return Response
     */
    public function prevalidation(Request $request): Response
    {
        $defaultData = ['send' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('validation', PreValidationFormType::class, ['label' => false,])
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $preValidationDataTool = new PrevalidationDataTool();
            $preValidationRequest = $preValidationDataTool->setData($data['validation']);

            $prevalidationRequestService = new PrevalidationRequestService($this->getParameter('univ.apirest'),$this->getParameter('univ.token'));
            $prevalidationRequestService->prevalidation($preValidationRequest);

            return $this->render('PreValidationRequest.html.twig', [
                'form' => $form->createView(),
                'originalResult' => $prevalidationRequestService->getOriginalResult(),
                'service' => $prevalidationRequestService,
            ]);
        }

        return $this->render('PreValidationRequest.html.twig', [
            'form' => $form->createView()
        ]);
    }
}