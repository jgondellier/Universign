<?php
namespace App\Util;

use Gondellier\UniversignBundle\Classes\Request\DocSignatureField;

class DocSignatureFieldDataTool
{
    public function setData(array $signatureFields):array
    {
        $docSignatureFields = array();
        foreach ($signatureFields as $signatureField) {
            $docSignatureField = new DocSignatureField();
            if(array_key_exists('name',$signatureField)){
                $docSignatureField->setName($signatureField['name']);
            }
            if(array_key_exists('page',$signatureField)){
                $docSignatureField->setPage($signatureField['page']);
            }else{
                $docSignatureField->setPage(-1);
            }
            if(array_key_exists('x',$signatureField)){
                $docSignatureField->setX($signatureField['x']);
            }else{
                $docSignatureField->setX(80);
            }
            if(array_key_exists('y',$signatureField)){
                $docSignatureField->setY($signatureField['y']);
            }else{
                $docSignatureField->setY(300);
            }
            if(array_key_exists('signerIndex',$signatureField)){
                $docSignatureField->setSignerIndex($signatureField['signerIndex']);
            }else{
                $docSignatureField->setSignerIndex(0);
            }
            if(array_key_exists('patternName',$signatureField)){
                $docSignatureField->setPatternName($signatureField['patternName']);
            }
            if(array_key_exists('label',$signatureField)){
                $docSignatureField->setLabel($signatureField['label']);
            }
            if(array_key_exists('image',$signatureField)){
                $docSignatureField->setImage($signatureField['image']);
            }
            $docSignatureFields[]=$docSignatureField;
        }
        return $docSignatureFields;
    }
}