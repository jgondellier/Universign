<?php

namespace App\Controller;

use Gondellier\UniversignBundle\Service\GetDocumentsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetDocumentsController extends AbstractController
{
    /**
     * @Route("/getdocuments/{id}", name="getdocuments")
     * @param Request $request
     * @param null $id
     * @return Response
     */
    public function getDocuments(Request $request, $id = null): Response
    {
        $defaultData = ['send' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('id', TextType::class)
            ->add('type', ChoiceType::class,[
                'required'   => false,
                'choices' => [
                    'id' => '',
                    'customId' => 'customId'
                ],
            ])
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if (($form->isSubmitted() && $form->isValid()) || $id !== null) {
            $data = $form->getData();
            if ($id === null) {
                $id = $data['id'];
            }
            $getDocumentService = new GetDocumentsService($this->getParameter('univ.uri'));
            if(array_key_exists('type',$data) && $data['type'] === 'customId'){
                $getDocumentService->getDocumentsByCustomID($id);
            }else{
                $getDocumentService->getDocuments($id);
            }

            $originalResult = $getDocumentService->getOriginalResult();
            $documents = array();
            if(!$getDocumentService->fault){
                $documentDirectory = 'documents/' . $id;
                if (!file_exists($documentDirectory) && !mkdir($documentDirectory, 0777, true) && !is_dir($documentDirectory)) {
                    die('Echec lors de la création des répertoires...');
                }
                foreach ($originalResult as $result) {
                    $documentName = $result['fileName'] . '.pdf';
                    $documentPath = $documentDirectory . '/' . $documentName;
                    file_put_contents($documentPath, $result['content']->scalar);
                    $documents[] = ['fileName' => $documentName, 'filePath' => '/'.$documentPath];
                }
            }

            return $this->render('getdocuments.html.twig', [
                'form' => $form->createView(),
                'service' => $getDocumentService,
                'originalResult' => $getDocumentService->getOriginalResult(),
                'documents' => $documents
            ]);
        }

        return $this->render('getdocuments.html.twig', [
            'form' => $form->createView()
        ]);
    }
}