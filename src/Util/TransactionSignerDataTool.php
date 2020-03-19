<?php

namespace App\Util;

use Gondellier\UniversignBundle\Classes\Request\RedirectionConfig;
use Gondellier\UniversignBundle\Classes\Request\RegistrationRequest;
use Gondellier\UniversignBundle\Classes\Request\TransactionSigner;

class TransactionSignerDataTool
{
    public function setData(array $data):TransactionSigner
    {
        $transactionSigner = new TransactionSigner();
        if(array_key_exists('firstname',$data)){
            $transactionSigner->setFirstname($data['firstname']);
        }
        if(array_key_exists('lastname',$data)){
            $transactionSigner->setLastname($data['lastname']);
        }
        if(array_key_exists('birthdate',$data)){
            $transactionSigner->setBirthDate($data['birthdate']);
        }
        if(array_key_exists('firstname',$data)){
            $transactionSigner->setOrganization($data['organisation']);
        }else{
            $transactionSigner->setOrganization('2');
        }
        if(array_key_exists('profile',$data)){
            $transactionSigner->setProfile($data['profile']);
        }else{
            $transactionSigner->setProfile('default');
        }
        if(array_key_exists('email',$data)){
            $transactionSigner->setEmailAddress($data['email']);
        }
        if(array_key_exists('mobile',$data)){
            $transactionSigner->setPhoneNum($data['mobile']);
        }
        if(array_key_exists('profile',$data)){
            $transactionSigner->setProfile($data['profile']);
        }else{
            $transactionSigner->setProfile('default');
        }
        if(array_key_exists('language',$data)){
            $transactionSigner->setLanguage($data['language']);
        }else{
            $transactionSigner->setLanguage('fr');
        }
        if(array_key_exists('role',$data)){
            $transactionSigner->setRole($data['role']);
        }else{
            $transactionSigner->setRole('signer');
        }
        if(array_key_exists('universignId',$data)){
            $transactionSigner->setUniversignId($data['universignId']);
        }
        $succesUrl = new RedirectionConfig();
        if(array_key_exists('successRedirection',$data)){
            $transactionSigner->setSuccessRedirection($data['successRedirection']);
        }else{
            $succesUrl->setURL('https://localhost/success');
            $succesUrl->setDisplayName('SuccessUrl');
            $transactionSigner->setSuccessRedirection($succesUrl);
        }
        $cancelUrl = new RedirectionConfig();
        if(array_key_exists('cancelRedirection',$data)){
            $transactionSigner->setCancelRedirection($data['cancelRedirection']);
        }else{
            $cancelUrl->setURL('https://localhost/cancel');
            $cancelUrl->setDisplayName('CancelUrl');
            $transactionSigner->setCancelRedirection($cancelUrl);
        }
        $failUrl = new RedirectionConfig();
        if(array_key_exists('failRedirection',$data)){
            $transactionSigner->setFailRedirection($data['failRedirection']);
        }else{
            $failUrl->setURL('https://localhost/fail');
            $failUrl->setDisplayName('FailUrl');
            $transactionSigner->setFailRedirection($failUrl);
        }
        if(array_key_exists('certificateType',$data)){
            $transactionSigner->setCertificateType($data['certificateType']);
        }
        if(array_key_exists('cni1',$data)){
            $registrationRequest = new RegistrationRequest();
            $registrationRequest->setType($data['type']);
            $registrationRequest->addDocuments($data['cni1']);
            if(array_key_exists('cni2',$data)) {
                $registrationRequest->addDocuments($data['cni2']);
            }
            $transactionSigner->setIdDocuments($registrationRequest);
        }
        if(array_key_exists('redirectPolicy',$data)){
            $transactionSigner->setRedirectPolicy($data['redirectPolicy']);
        }
        if(array_key_exists('redirectWait',$data)){
            $transactionSigner->setRedirectWait($data['redirectWait']);
        }
        if(array_key_exists('autoSendAgreements',$data)){
            $transactionSigner->setAutoSendAgreements($data['autoSendAgreements']);
        }

        return $transactionSigner;
    }
}