<?php

namespace App\Util;

use Gondellier\UniversignBundle\Classes\RedirectionConfig;
use Gondellier\UniversignBundle\Classes\RegistrationRequest;
use Gondellier\UniversignBundle\Classes\TransactionSigner;

class TransactionSignerDataTool
{
    /**
     * Return trnsactionSigner list
     *
     * @param array $signer
     * @return TransactionSigner
     */
    public function setData(array $signer): TransactionSigner
    {
        $transactionSigner = new TransactionSigner();
        if (array_key_exists('firstname', $signer) && !empty($signer['firstname'])) {
            $transactionSigner->setFirstname($signer['firstname']);
        }
        if (array_key_exists('lastname', $signer) && !empty($signer['lastname'])) {
            $transactionSigner->setLastname($signer['lastname']);
        }
        if (array_key_exists('birthdate', $signer) && !empty($signer['birthdate'])) {
            $transactionSigner->setBirthDate($signer['birthdate']);
        }
        if (array_key_exists('organisation', $signer) && !empty($signer['organisation'])) {
            $transactionSigner->setOrganization($signer['organisation']);
        } else {
            $transactionSigner->setOrganization('2');
        }
        if (array_key_exists('profile', $signer) && !empty($signer['profile'])) {
            $transactionSigner->setProfile($signer['profile']);
        } else {
            $transactionSigner->setProfile('default');
        }
        if (array_key_exists('email', $signer) && !empty($signer['email'])) {
            $transactionSigner->setEmailAddress($signer['email']);
        }
        if (array_key_exists('mobile', $signer) && !empty($signer['mobile'])) {
            $transactionSigner->setPhoneNum($signer['mobile']);
        }
        if (array_key_exists('language', $signer) && !empty($signer['language'])) {
            $transactionSigner->setLanguage($signer['language']);
        } else {
            $transactionSigner->setLanguage('fr');
        }
        if (array_key_exists('role', $signer) && !empty($signer['role'])) {
            $transactionSigner->setRole($signer['role']);
        } else {
            $transactionSigner->setRole('signer');
        }
        if (array_key_exists('universignId', $signer) && !empty($signer['universignId'])) {
            $transactionSigner->setUniversignId($signer['universignId']);
        }
        $succesRedirectionUrl = new RedirectionConfig();
        if (array_key_exists('successRedirection', $signer)
            && !empty($signer['successRedirection'])
            && array_key_exists('URL', $signer['successRedirection'])
            && !empty($signer['successRedirection']['URL'])) {
            $succesRedirectionUrl->setDisplayName($signer['successRedirection']['displayName']);
            $succesRedirectionUrl->setURL($signer['successRedirection']['URL']);
            $transactionSigner->setSuccessRedirection($succesRedirectionUrl);
        }
        $cancelRedirectionUrl = new RedirectionConfig();
        if (array_key_exists('cancelRedirection', $signer)
            && !empty($signer['cancelRedirection'])
            && array_key_exists('URL', $signer['cancelRedirection'])
            && !empty($signer['cancelRedirection']['URL'])) {
            $cancelRedirectionUrl->setDisplayName($signer['cancelRedirection']['displayName']);
            $cancelRedirectionUrl->setURL($signer['cancelRedirection']['URL']);
            $transactionSigner->setCancelRedirection($cancelRedirectionUrl);
        }
        $failRedirectionUrl = new RedirectionConfig();
        if (array_key_exists('failRedirection', $signer)
            && !empty($signer['failRedirection'])
            && array_key_exists('URL', $signer['failRedirection'])
            && !empty($signer['failRedirection']['URL'])) {
            $failRedirectionUrl->setDisplayName($signer['failRedirection']['displayName']);
            $failRedirectionUrl->setURL($signer['failRedirection']['URL']);
            $transactionSigner->setFailRedirection($failRedirectionUrl);
        }
        if (array_key_exists('certificateType', $signer) && !empty($signer['certificateType'])) {
            $transactionSigner->setCertificateType($signer['certificateType']);
        }
        if (array_key_exists('cni1', $signer) && !empty($signer['cni1'])) {
            $registrationRequest = new RegistrationRequest();
            $registrationRequest->setType($signer['type']);
            $registrationRequest->addDocuments($signer['cni1']);
            if (array_key_exists('cni2', $signer) && !empty($signer['cni2'])) {
                $registrationRequest->addDocuments($signer['cni2']);
            }
            $transactionSigner->setIdDocuments($registrationRequest);
        }
        if (array_key_exists('validationSessionId', $signer) && !empty($signer['validationSessionId'])) {
            $transactionSigner->setValidationSessionId($signer['validationSessionId']);
        }
        if (array_key_exists('redirectPolicy', $signer) && !empty($signer['redirectPolicy'])) {
            $transactionSigner->setRedirectPolicy($signer['redirectPolicy']);
        }
        if (array_key_exists('redirectWait', $signer) && !empty($signer['redirectWait'])) {
            $transactionSigner->setRedirectWait($signer['redirectWait']);
        }
        if (array_key_exists('autoSendAgreements', $signer) && !empty($signer['autoSendAgreements'])) {
            $transactionSigner->setAutoSendAgreements($signer['autoSendAgreements']);
        }

        return $transactionSigner;
    }
}