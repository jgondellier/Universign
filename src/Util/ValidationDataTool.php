<?php

namespace App\Util;

use Gondellier\UniversignBundle\Classes\Request\IdDocument;
use Gondellier\UniversignBundle\Classes\Request\PersonalInfo;
use Gondellier\UniversignBundle\Classes\Request\ValidationRequest;

class ValidationDataTool
{
    public function setData(array $data) :ValidationRequest
    {
        $IdDocument = new IdDocument();
        $IdDocument->setType(0);
        $IdDocument->addPhotos($data['cni1']);
        if(isset($data['cni2'])){
            $IdDocument->addPhotos($data['cni2']);
        }
        $IdDocument->verifyTypeWithPhoto();

        $personalInfo = new PersonalInfo();
        $personalInfo->setFirstname($data['firstname']);
        $personalInfo->setLastname($data['lastname']);
        $personalInfo->setBirthDate($data['birthdate']);

        $validationRequest = new ValidationRequest();
        $validationRequest->setPersonalInfo($personalInfo);
        $validationRequest->setIdDocument($IdDocument);
        $validationRequest->setAllowManual(0);
        $validationRequest->setCallbackURL('http://localhost/toto');

        return $validationRequest;
    }
}