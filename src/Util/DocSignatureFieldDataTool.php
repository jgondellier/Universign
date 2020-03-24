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
            $find = false;
            if(array_key_exists('name',$signatureField) && !empty($signatureField['name'])){
                $docSignatureField->setName($signatureField['name']);
                $find = true;
            }
            if(array_key_exists('x',$signatureField) && !empty($signatureField['x'])){
                $docSignatureField->setX($signatureField['x']);
                $find = true;
            }
            if(array_key_exists('y',$signatureField) && !empty($signatureField['y'])){
                $docSignatureField->setY($signatureField['y']);
                $find = true;
            }
            if(array_key_exists('page',$signatureField) && !empty($signatureField['page'])){
                $docSignatureField->setPage($signatureField['page']);
            }
            if(array_key_exists('signerIndex',$signatureField) && ($signatureField['signerIndex'] !== '' && $signatureField['signerIndex']!==null)){
                $docSignatureField->setSignerIndex($signatureField['signerIndex']);
            }else{
                $docSignatureField->setSignerIndex(0);
            }
            if(array_key_exists('patternName',$signatureField) && !empty($signatureField['patternName'])){
                $docSignatureField->setPatternName($signatureField['patternName']);
            }
            if(array_key_exists('label',$signatureField) && !empty($signatureField['label'])){
                $docSignatureField->setLabel($signatureField['label']);
            }
            if(array_key_exists('image',$signatureField) && !empty($signatureField['image'])){
                $docSignatureField->setImage($signatureField['image']);
            }
            //Vérificationdes champs obligatoire.
            //$docSignatureField->check();
            $docSignatureFields[]=$docSignatureField->getArray();
        }
        return $docSignatureFields;
    }
}