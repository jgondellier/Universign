<?php

namespace App\Controller;

use Gondellier\UniversignBundle\Classes\Request\IdDocument;
use Gondellier\UniversignBundle\Classes\Request\PersonalInfo;
use Gondellier\UniversignBundle\Classes\Request\ValidationRequest;
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
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('birthdate', BirthdayType::class,['format' => 'dd-MM-yyyy',])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'carte nationale d’identité' => 0,
                    'passeport' => 1,
                    'permis de séjour' => 2,
                    'permis de conduire Européen' => 3,
                ]])
            ->add('cni1', FileType::class,[
                'required' => true,
            ])
            ->add('cni2', FileType::class,['required' => false,])
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $IdDocument = new IdDocument();
            $IdDocument->setType(0);
            $IdDocument->addPhotos($data['cni1']);
            if(isset($data['cni2'])){
                $IdDocument->addPhotos($data['cni2']);
            }

            $personalInfo = new PersonalInfo();
            $personalInfo->setFirstname($data['firstname']);
            $personalInfo->setLastname($data['lastname']);
            $personalInfo->setBirthDate($data['birthdate']);

            $validationRequest = new ValidationRequest();
            $validationRequest->setPersonalInfo($personalInfo);
            $validationRequest->setIdDocument($IdDocument);
            $validationRequest->setAllowManual(0);
            $validationRequest->setCallbackURL('http://localhost/toto');

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
}