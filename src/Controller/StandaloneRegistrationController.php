<?php

namespace App\Controller;

use Gondellier\UniversignBundle\Classes\Request\RedirectionConfig;
use Gondellier\UniversignBundle\Classes\Request\RegistrationRequest;
use Gondellier\UniversignBundle\Classes\Request\StandaloneRegistration;
use Gondellier\UniversignBundle\Classes\Request\TransactionSigner;
use Gondellier\UniversignBundle\Service\StandaloneRegistrationRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StandaloneRegistrationController extends AbstractController
{
    /**
     * @Route("/universign/standaloneregistration", name="standaloneregistration")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function standaloneregistration(Request $request): Response
    {
        $defaultData = ['send' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('birthdate', BirthdayType::class,['format' => 'dd-MM-yyyy',])
            ->add('prevalCNI',CheckboxType::class, [
                'label' => 'Pièce d\'identité déja validée ?',
                'required' => false,
                'attr' => array(
                    'onchange' => 'changePrevalChoice()',
                ),
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'carte nationale d’identité' => 'id_card_fr',
                    'passeport' => 'passport_eu',
                    'permis de séjour' => 'titre_sejour',
                    'permis de conduire Européen' => 'drive_license',
                ]])
            ->add('cni1', FileType::class,['required' => false])
            ->add('cni2', FileType::class,['required' => false])
            ->add('certificateType', ChoiceType::class, [
                'choices' => [
                    'simple' => 'simple',
                    'certified' => 'certified',
                    'advanced' => 'advanced',
                ],
                'attr' => array(
                    'onchange' => 'changeCertificateTypeChoice()',
                ),
                'data' => 'certified',
                ])
            ->add('validationSessionId', TextType::class,[
                'required' => false
                ])
            ->add('email', EmailType::class)
            ->add('mobile', TelType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $transactionSigner = new TransactionSigner();
            $transactionSigner->setFirstname($data['firstname']);
            $transactionSigner->setLastname($data['lastname']);
            $transactionSigner->setBirthDate($data['birthdate']);
            $transactionSigner->setOrganization('2');
            $transactionSigner->setProfile('default');
            $transactionSigner->setEmailAddress($data['email']);
            $transactionSigner->setPhoneNum($data['mobile']);
            $transactionSigner->setLanguage('fr');
            $transactionSigner->setRole('signer');
            //$transactionSigner->setUniversignId('qsfsdq');
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
            $transactionSigner->setCertificateType($data['certificateType']);
            if($data['cni1']){
                $registrationRequest = new RegistrationRequest();
                $registrationRequest->setType($data['type']);
                $registrationRequest->addDocuments($data['cni1']);
                $registrationRequest->addDocuments($data['cni2']);
                if($registrationRequest){
                    $transactionSigner->setIdDocuments($registrationRequest);
                }
            }
            if(!empty($data['validationSessionId'])){
                $transactionSigner->setValidationSessionId($data['validationSessionId']);
            }

            $transactionSigner->setRedirectPolicy('dashboard');
            $transactionSigner->setRedirectWait(5);
            $transactionSigner->setAutoSendAgreements(false);

            $standaloneRegistration = new StandaloneRegistration();
            $standaloneRegistration->setProfile('default');
            $standaloneRegistration->setSigner($transactionSigner);
            $standaloneRegistrationRequestService = new StandaloneRegistrationRequestService($this->getParameter('univ.uri'));
            $standaloneRegistrationRequestService->validate($standaloneRegistration);


            return $this->render('universign/standaloneregistration.html.twig', [
                'form' => $form->createView(),
                'requestresponse' => $standaloneRegistrationRequestService->getOriginalResult(),
            ]);
        }
        return $this->render('universign/standaloneregistration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
