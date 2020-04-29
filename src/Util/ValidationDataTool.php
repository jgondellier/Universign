<?php

namespace App\Util;

use Gondellier\UniversignBundle\Classes\IdDocument;
use Gondellier\UniversignBundle\Classes\PersonalInfo;
use Gondellier\UniversignBundle\Classes\ValidationRequest;

class ValidationDataTool
{
    public function setData(array $data) :ValidationRequest
    {
        $IdDocument = new IdDocument();
        if (array_key_exists('type', $data) && ($data['type']!==null)) {
            $IdDocument->setType($data['type']);
        }
        $IdDocument->addPhotos($data['cni1']);
        if (array_key_exists('cni2', $data) && !empty($data['cni2'])) {
            $IdDocument->addPhotos($data['cni2']);
        }
        //$IdDocument->verifyTypeWithPhoto();

        $personalInfo = new PersonalInfo();
        if (array_key_exists('firstname', $data) && !empty($data['firstname'])) {
            $personalInfo->setFirstname($data['firstname']);
        }
        if (array_key_exists('lastname', $data) && !empty($data['lastname'])) {
            $personalInfo->setLastname($data['lastname']);
        }
        if (array_key_exists('birthdate', $data) && !empty($data['birthdate'])) {
            $personalInfo->setBirthDate($data['birthdate']);
        }

        $validationRequest = new ValidationRequest();
        $validationRequest->setPersonalInfo($personalInfo);
        $validationRequest->setIdDocument($IdDocument);
        if (array_key_exists('allowManual', $data) && !empty($data['allowManual'])) {
            $validationRequest->setAllowManual($data['allowManual']);
        }

        if (array_key_exists('callbackURL', $data) && !empty($data['callbackURL'])) {
            $validationRequest->setCallbackURL($data['callbackURL']);
        }



        return $validationRequest;
    }
}