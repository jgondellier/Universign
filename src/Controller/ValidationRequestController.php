<?php

namespace App\Controller;

use App\Form\Type\ValidationFormType;
use App\Util\ValidationDataTool;
use Gondellier\UniversignBundle\Classes\IdDocument;
use Gondellier\UniversignBundle\Classes\PersonalInfo;
use Gondellier\UniversignBundle\Classes\ValidationRequest;
use Gondellier\UniversignBundle\Service\ValidationRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValidationRequestController extends AbstractController
{
    /**
     * @Route("/validationrequest", name="validationrequest")
     * @param Request $request
     * @return Response
     */
    public function validationrequest(Request $request): Response
    {
        $defaultData = ['send' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('validation', ValidationFormType::class, ['label' => false,])
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $validationDataTool = new ValidationDataTool();
            $validationRequest = $validationDataTool->setData($data['validation']);

            $validationRequestService = new ValidationRequestService($this->getParameter('univ.uri'));
            $validationRequestService->validate($validationRequest);

            return $this->render('ValidationRequest.html.twig', [
                'form' => $form->createView(),
                'originalResult' => $validationRequestService->getOriginalResult(),
                'service' => $validationRequestService,
                'explanation' => $validationRequestService->getExplanation()
            ]);
        }

        return $this->render('ValidationRequest.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/validationrequest/getresult", name="validationrequestGetresult")
     * @param Request $request
     * @return Response
     */
    public function getResult(Request $request): Response
    {
        $defaultData = ['send' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('id', TextType::class)
            ->add('send', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $validationRequestService = new ValidationRequestService($this->getParameter('univ.uri'));
            $validationRequestService->getResult($data['id']);

            return $this->render('ValidateGetResult.html.twig', [
                'form' => $form->createView(),
                'originalResult' => $validationRequestService->getOriginalResult(),
                'service' => $validationRequestService,
                'explanation' => $validationRequestService->getExplanation()
            ]);
        }

        return $this->render('ValidateGetResult.html.twig', [
            'form' => $form->createView()
        ]);
    }
}