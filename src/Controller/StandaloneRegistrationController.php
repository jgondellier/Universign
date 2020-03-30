<?php

namespace App\Controller;

use App\Form\Type\TransactionSignerFormType;
use App\Util\TransactionDocumentDataTool;
use App\Util\TransactionRequestDataTool;
use App\Util\TransactionSignerDataTool;
use Gondellier\UniversignBundle\Classes\RedirectionConfig;
use Gondellier\UniversignBundle\Classes\RegistrationRequest;
use Gondellier\UniversignBundle\Classes\StandaloneRegistration;
use Gondellier\UniversignBundle\Classes\TransactionSigner;
use Gondellier\UniversignBundle\Service\StandaloneRegistrationRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StandaloneRegistrationController extends AbstractController
{
    /**
     * @Route("/standaloneregistration", name="standaloneregistration")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function standaloneregistration(Request $request): Response
    {
        $defaultData = ['send' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('signer',TransactionSignerFormType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $transactionSignerDataTool = new TransactionSignerDataTool();
            $transactionSigner = $transactionSignerDataTool->setData($data['signer']);

            $succesUrl = new RedirectionConfig();
            $succesUrl->setURL('https://localhost/success');
            $succesUrl->setDisplayName('SuccessUrl');
            $transactionSigner->setSuccessRedirection($succesUrl);
            $cancelUrl = new RedirectionConfig();
            $cancelUrl->setURL('https://localhost/cancel');
            $cancelUrl->setDisplayName('CancelUrl');
            $transactionSigner->setCancelRedirection($cancelUrl);
            $failUrl = new RedirectionConfig();
            $failUrl->setURL('https://localhost/fail');
            $failUrl->setDisplayName('FailUrl');
            $transactionSigner->setFailRedirection($failUrl);

            $standaloneRegistration = new StandaloneRegistration();
            $standaloneRegistration->setProfile('default');
            $standaloneRegistration->setSigner($transactionSigner);
            $standaloneRegistrationRequestService = new StandaloneRegistrationRequestService($this->getParameter('univ.uri'));
            $standaloneRegistrationRequestService->validate($standaloneRegistration);


            return $this->render('standaloneregistration.html.twig', [
                'form' => $form->createView(),
                'service' => $standaloneRegistrationRequestService,
                'originalResult' => $standaloneRegistrationRequestService->getOriginalResult(),
            ]);
        }
        return $this->render('standaloneregistration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
