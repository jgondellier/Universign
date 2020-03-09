<?php

namespace App\Controller;

use App\Service\MatchAccount;
use App\Service\PreValidation;
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
        $defaultData = ['name' => ''];
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
            $params = array('firstname'=>$data['firstname'],'lastname'=>$data['lastname'],'email'=>$data['email'],'mobile'=>$data['mobile']);
            $matchAccount->match($params);

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
        $defaultData = ['name' => ''];
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
                'required' => false,
                ])
            ->add('cni2', FileType::class,['required' => false,])
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $cni1  = file_get_contents($data['cni1']);
            xmlrpc_set_type($cni1,'base64');
            $cni2  = file_get_contents($data['cni2']);
            xmlrpc_set_type($cni2,'base64');
            $birthDate = date_format($data['birthdate'],'Y-m-dTh:m:s');
            xmlrpc_set_type($birthDate,'datetime');
            $params=array(
                'idDocument'=>array(
                    'photos'=>array(
                        $cni1,
                        $cni2
                    ),
                    'type'=>$data['type']
                ),
                'personalInfo'=>array(
                    'firstname'=>$data['firstname'],
                    'lastname'=>$data['lastname'],
                    'birthDate'=>$birthDate
                ),
                'allowManual'=>False,
                'CallbackUrl'=>''
            );

            $preValidation->validate($params);
            exit;
        }

        return $this->render('universign/prevalidation.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
