<?php

namespace App\Controller;

use App\Service\MatchAccount;
use App\Service\PreValidation;
use App\Service\TransactionSigner;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\File;

class UniversignController extends AbstractController
{

    /**
     * @Route("/universign/matchaccount", name="matchaccount")
     * @param Request $request
     * @param MatchAccount $matchAccount
     * @return Response
     */
    public function matchaccount(Request $request, MatchAccount $matchAccount)
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

            $matchAccount->match($data);

            return $this->render('universign/matchaccount.html.twig', [
                'form' => $form->createView(),
                'bestResult' => $matchAccount->getBestResult(),
                'explanation' => $matchAccount->getExplanation(),
                'isValid1' => $matchAccount->isValid(1),
                'isValid2' => $matchAccount->isValid(2),
            ]);
        }

        return $this->render('universign/matchaccount.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
 * @Route("/universign/prevalidation", name="prevalidation")
 * @param Request $request
 * @param PreValidation $preValidation
 * @return Response
 */
    public function prevalidation(Request $request,PreValidation $preValidation)
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
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $preValidation->validate($data);
            return $this->render('universign/prevalidation.html.twig', [
                'form' => $form->createView(),
                'response' => $preValidation
            ]);
        }

        return $this->render('universign/prevalidation.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/universign/transactionsigner", name="transactionsigner")
     * @param Request $request
     * @param TransactionSigner $transactionSigner
     * @return Response
     */
    public function transactionSigner(Request $request,TransactionSigner $transactionSigner)
    {
        $defaultData = ['lastname' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('birthdate', BirthdayType::class,['format' => 'dd-MM-yyyy',])
            ->add('email', EmailType::class)
            ->add('mobile', TelType::class)
            ->add('certificateType', ChoiceType::class, [
                'choices' => [
                    'simple' => 'simple',
                    'certified' => 'certified',
                    'advanced' => 'advanced',
                ]])
            ->add('doc', FileType::class,[
                'required' => false,
            ])
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $transactionSigner->sign($data);

            exit;
        }

        return $this->render('universign/transactionsigner.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
