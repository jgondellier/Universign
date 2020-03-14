<?php

namespace App\Controller;

use Gondellier\UniversignBundle\Classes\Request\RegistrationRequest;
use Gondellier\UniversignBundle\Classes\Request\TransactionSigner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
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
        $defaultData = ['lastname' => ''];
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
            ->add('certificateType', ChoiceType::class, [
                'choices' => [
                    'simple' => 'simple',
                    'certified' => 'certified',
                    'advanced' => 'advanced',
                ]])
            ->add('email', EmailType::class)
            ->add('mobile', TelType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $IdDocument = new RegistrationRequest();
            $IdDocument->setType('id_card_fr');
            $IdDocument->addDocuments('CNI-Corinne_Berthier-Recto.jpg');
            $IdDocument->addDocuments('CNI-Corinne_Berthier-Verso.jpg');

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
            $transactionSigner->setUniversignId();
            $transactionSigner->setSuccessRedirection('https://localhost/success');
            $transactionSigner->setCancelRedirection('https://localhost/cancel');
            $transactionSigner->setFailRedirection('https://localhost/fail');
            $transactionSigner->setCertificateType($data['certificateType']);
            $transactionSigner->setIdDocuments();
            $transactionSigner->setValidationSessionId();
            $transactionSigner->setRedirectPolicy('dashboard');
            $transactionSigner->setRedirectWait(5);
            $transactionSigner->setAutoSendAgreements(true);

            var_dump($transactionSigner->getArray());
            var_dump($transactionSigner->getArray());exit;


            return $this->render('universign/standaloneregistration.html.twig', [
                'form' => $form->createView()
            ]);
        }
        return $this->render('universign/standaloneregistration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
