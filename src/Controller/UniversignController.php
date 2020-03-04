<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UniversignController extends AbstractController
{
    /**
     * @Route("/universign", name="universign")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('name', TextType::class)
            ->add('firstname', TextType::class)
            ->add('birthdate', TextType::class)
            ->add('email', EmailType::class)
            ->add('tel', TextType::class)
            ->add('message', TextareaType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
        }

        return $this->render('universign/index.html.twig', [
            'controller_name' => 'UniversignController',
        ]);
    }
}
