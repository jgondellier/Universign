<?php

namespace App\Util;

use App\Gondellier\UniversignBundle\Classes\PrevalidationRequest;

class PrevalidationDataTool
{
    public function setData(array $data) :PrevalidationRequest
    {
        $prevalidationRequest = new PrevalidationRequest();
        if (array_key_exists('family_name', $data) && !empty($data['family_name'])) {
            $prevalidationRequest->setFamilyName($data['family_name']);
        }
        if (array_key_exists('given_name', $data) && !empty($data['given_name'])) {
            $prevalidationRequest->setGivenName($data['given_name']);
        }
        if (array_key_exists('birth_date', $data) && !empty($data['birth_date'])) {
            $prevalidationRequest->setBirthDate($data['birth_date']);
        }
        if (array_key_exists('cni1', $data) && !empty($data['cni1'])) {
            $file = $data['cni1'];
            $prevalidationRequest->addFile($file,$file->getClientOriginalName());
        }
        if (array_key_exists('cni2', $data) && !empty($data['cni2'])) {
            $file = $data['cni2'];
            $prevalidationRequest->addFile($file,$file->getClientOriginalName());
        }
        if (array_key_exists('document_type', $data) && !empty($data['document_type'])) {
            foreach($data['document_type'] as $documentType){
                $prevalidationRequest->addDocumentType($documentType['document_type']);
            }
        }
        if (array_key_exists('expires_after', $data) && !empty($data['expires_after'])) {
            $prevalidationRequest->setExpiresAfter($data['expires_after']);
        }
        if (array_key_exists('color_required', $data) && ($data['color_required'] !== '' && $data['color_required'] !== null)) {
            $prevalidationRequest->setColorRequired($data['color_required']);
        }
        if (array_key_exists('profile', $data) && !empty($data['profile'])) {
            $prevalidationRequest->setProfile($data['profile']);
        }
        return $prevalidationRequest;
    }
}