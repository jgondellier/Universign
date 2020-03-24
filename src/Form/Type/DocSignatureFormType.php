<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DocSignatureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('name', TextType::class,[
                'required' => false,
                'help' => 'Nom du champ de signature déjà présent dans le document : lors de la signature, ce champ sera remplacé par le cartouche de signature. Si le nom est renseigné, la page, et les coordonnées x et y deviennent alors optionnels. Le cartouche de signature existant doit avoir la même taille que le cartouche de signature électronique. Si le champ correspondant au name n’est pas trouvé dans le document PDF, alors, les attributs x, y et page sont obligatoires',
                ])
            ->add('page', IntegerType::class,[
                'required' => true,
                'help' => 'Numéro de la page du document qui commence à 1. La valeur -1 correspond à la dernière page.'
                ])
            ->add('x', IntegerType::class,[
                'required' => false,
                'help' => 'Coordonnées x du champ de signature dans une page, valant de 0 à 595 pour une page A4 en portrait. Si aucune valeur n’est saisie, la valeur 0 est attribuée par défaut.'
                ])
            ->add('y', IntegerType::class,[
                'required' => false,
                'help' => 'Coordonnées y du champ de signature dans une page, valant de 0 à 842 pour une page A4 en portrait. Si aucune valeur n’est saisie, la valeur 0 est attribuée par défaut.'
                ])
            ->add('signerIndex', IntegerType::class,[
                'required' => false,
                'help' => 'Index du signataire de la collecte, le 1er signataire porte l’index 0.'
                ])
            ->add('patternName',TextType::class,[
                'required' => false,
                'help' => 'Libellé correspondant au cartouche de signature personnalisé. Universign propose un cartouche par défaut nommé « default », en l’absence de valeur, le cartouche «default » est utilisé.'
                ])
            ->add('label',TextType::class,[
                'required' => false,
                'help' => 'Intitulé de la signature du document.'
                ])
            ->add('image',FileType::class,[
                'required' => false,
                'attr' => array(
                    'onchange' => 'loadFileName(this)',
                ),
                'help' => 'The image to be displayed in the signature field, it will replace the default UNIVERSIGN logo. Image format must be JPG, JPEG or PNG. 
                A recommended resolution for this image is 150x36px.The image will be resized if the image has a different resolution.'
            ])
        ;
    }

    public function getBlockPrefix():string
    {
        return 'DocSignatureFormType';
    }
}