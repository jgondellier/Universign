<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionRequestController extends AbstractController
{
    /**
     * @Route("/universign/transactionrequest", name="transactionrequest")
     * @param Request $request
     * @return Response
     */
    public function transactionrequest(Request $request): Response
    {
        return $this->render('universign/index.html.twig');
    }
}