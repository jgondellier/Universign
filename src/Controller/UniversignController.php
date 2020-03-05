<?php

namespace App\Controller;

use App\Universign\Utils\MatchAccount;
use GuzzleHttp\Client;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        $defaultData = ['name' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('birthdate', BirthdayType::class,['required' => false,])
            ->add('email', EmailType::class)
            ->add('mobile', TelType::class)
            ->add('cni1', FileType::class,['required' => false,])
            ->add('cni2', FileType::class,['required' => false,])
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
            //var_dump($data);
            $uri = 'https://'.$this->getParameter('univ.user').':'.$this->getParameter('univ.pass').'@'.$this->getParameter('univ.path');
            $params = array('firstname'=>$data['firstname'],'lastname'=>$data['lastname'],'email'=>$data['email'],'mobile'=>$data['mobile']);
            //var_dump(xmlrpc_encode($params) );
            $client = new Client([
                'base_uri'  => '',
                'timeout'   => 200.0,
                'verify'    => false,
            ]);

            $response = $client->request('GET', $uri, ['body' => xmlrpc_encode_request('matcher.matchAccount',$params)]);
            $t_response = xmlrpc_decode($response->getBody()->getContents());
            $matchAccountresult = new MatchAccount($t_response);

            return $this->render('universign/index.html.twig', [
                'form' => $form->createView(),
                'bestResult' => $matchAccountresult->getBestResult(),
                'explanation' => $matchAccountresult->getExplanation(),
                'isValid1' => $matchAccountresult->isValid(1),
                'isValid2' => $matchAccountresult->isValid(2),
            ]);
        }

        return $this->render('universign/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
