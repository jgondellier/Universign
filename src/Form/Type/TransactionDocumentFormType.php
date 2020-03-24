<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class TransactionDocumentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', IntegerType::class,[
                'required' => false,
                'help'=>'A unique identifier of this document.'
            ])
            ->add('documentType', ChoiceType::class, [
                'choices' => [
                    'pdf' => 'pdf',
                    'pdf-for-presentation' => 'pdf-for-presentation',
                    'pdf-optional' => 'pdf-optional',
                    'sepa' => 'sepa',
                ],
                'required' => true,
                'help'=>'This TransactionDocument type. Valid values are: pdf The default value. Makes all TransactionDocument members relevant, except for SEPAData
                        pdf-for-presentation This value marks the document as view only. pdf-optional This type of PDF document can be refused and not signed by any signer without canceling the transaction.
                        sepa Using this value, no PDF document is provided,but UNIVERSIGN creates a SEPA mandate from data sent in SEPAData, which becomes the single relevant member.',
            ])
            ->add('content', FileType::class,[
                'label' => 'content',
                'attr' => array(
                    'onchange' => 'loadFileName(this)',
                    'accept' => 'application/pdf,application/x-pdf'
                ),
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
                'help'=>'The raw content of the PDF document. You can provide the document using the url field, otherwise this field is mandatory.'
            ])
            ->add('url', UrlType::class,[
                'required'   => false,
                'help' =>'The URL to download the PDF document. Note that this field is mandatory if the content is not set'
            ])
            ->add('fileName', TextType::class,[
                'required'   => true,
                'help' => 'The file name of this document.'
            ])
            ->add('signatureFields',DocSignaturesFormType::class,[
                'required'   => false,
                'help' => 'A description of a visible PDF signature field.'
            ])
            ->add('checkBoxTexts',ListCheckBoxTextsFormType::class,[
                'required'   => false,
                'help' => 'Texts of the agreement checkboxes. The last one should be the text of the checkbox related to signature fields labels agreement. This attribute should
                 not be used with documents of the type "pdf-for-presentation". Since agreement for "pdf-for-presentation" is not customisable.'
            ])
            ->add('metaData',TextType::class,[
                'required'   => false,
                'help' => 'This structure can only contain simple types like integer, string or date.'
            ])
            ->add('title',TextType::class,[
                'required'   => false,
                'help' => 'A title to be used for display purpose.'
            ])
            ->add('SEPAData',SepaDataFormType::class,[
                'required'   => false,
                'help' => 'A structure containing data to create a SEPA mandate PDF.'
            ])
        ;
    }
    public function getBlockPrefix(): string
    {
        return 'TransactionDocumentFormType';
    }
}