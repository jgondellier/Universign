<?php
namespace App\Util;

use Gondellier\UniversignBundle\Classes\Request\DocSignatureField;

class DocSignatureFieldDataTool
{
    public function setData($data):DocSignatureField
    {
        $docSignatureField = new DocSignatureField();
        if(array_key_exists('name',$data)){
            $docSignatureField->setName($data['name']);
        }
        if(array_key_exists('page',$data)){
            $docSignatureField->setPage($data['page']);
        }else{
            $docSignatureField->setPage(-1);
        }
        if(array_key_exists('x',$data)){
            $docSignatureField->setX($data['x']);
        }else{
            $docSignatureField->setX(80);
        }
        if(array_key_exists('y',$data)){
            $docSignatureField->setY($data['y']);
        }else{
            $docSignatureField->setY(300);
        }
        if(array_key_exists('signerIndex',$data)){
            $docSignatureField->setSignerIndex($data['signerIndex']);
        }else{
            $docSignatureField->setSignerIndex(0);
        }
        if(array_key_exists('patternName',$data)){
            $docSignatureField->setPatternName($data['patternName']);
        }
        if(array_key_exists('label',$data)){
            $docSignatureField->setLabel($data['label']);
        }
        if(array_key_exists('image',$data)){
            $docSignatureField->setImage($data['image']);
        }

        return $docSignatureField;
    }
}