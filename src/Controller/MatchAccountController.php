<?php

namespace App\Controller;

use Gondellier\UniversignBundle\Classes\Request\MatchAccount;
use Gondellier\UniversignBundle\Service\MatchAccountRequestService;
use Gondellier\UniversignBundle\Service\UniversignRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchAccountController extends AbstractController
{
    /**
     * @Route("/universign/matchaccount", name="matchaccount")
     * @param Request $request
     * @return Response
     */
    public function matchaccount(Request $request): Response
    {
        $defaultData = ['lastname' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('email', EmailType::class)
            ->add('mobile', TelType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $matchAccount = new MatchAccount();
            $matchAccount->setFirstname($data['firstname']);
            $matchAccount->setLastname($data['lastname']);
            $matchAccount->setEmail($data['email']);
            $matchAccount->setMobile($data['mobile']);

            $matchAccountService = new MatchAccountRequestService($this->getParameter('univ.uri'));
            $matchAccountService->match($matchAccount);

            return $this->render('matchaccount.html.twig', [
                'form' => $form->createView(),
                'originalResult' => $matchAccountService->getOriginalResult(),
                'service' => $matchAccountService,
                'isValid1' => $matchAccountService->isValid(1),
                'isValid2' => $matchAccountService->isValid(2),
            ]);
        }

        return $this->render('matchaccount.html.twig', [
            'form' => $form->createView()
        ]);
    }

}