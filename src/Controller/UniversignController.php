<?php

namespace App\Controller;


use Gondellier\UniversignBundle\Classes\Request\TransactionSigner;
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


class UniversignController extends AbstractController
{


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
