<?php

namespace App\Util;

use Gondellier\UniversignBundle\Classes\Request\TransactionRequest;

class TransactionRequestDataTool
{
    public function setData($data): TransactionRequest
    {
        $transactionRequest = new TransactionRequest();
        if (array_key_exists('profile', $data) && !empty($data['profile'])) {
            $transactionRequest->setProfile($data['profile']);
        }
        if (array_key_exists('customId', $data) && !empty($data['customId'])) {
            $transactionRequest->setCustomId($data['customId']);
        }
        if (array_key_exists('mustContactFirstSigner', $data) && !empty($data['mustContactFirstSigner'])) {
            $transactionRequest->setMustContactFirstSigner($data['mustContactFirstSigner']);
        }
        if (array_key_exists('finalDocSent', $data) && !empty($data['finalDocSent'])) {
            $transactionRequest->setFinalDocSent($data['finalDocSent']);
        }
        if (array_key_exists('finalDocRequesterSent', $data) && !empty($data['finalDocRequesterSent'])) {
            $transactionRequest->setFinalDocRequesterSent($data['finalDocRequesterSent']);
        }
        if (array_key_exists('finalDocObserverSent', $data) && !empty($data['finalDocObserverSent'])) {
            $transactionRequest->setFinalDocObserverSent($data['finalDocObserverSent']);
        }
        if (array_key_exists('description', $data) && !empty($data['description'])) {
            $transactionRequest->setDescription($data['description']);
        }
        /*if (array_key_exists('certificateType', $data) && !empty($data['certificateType'])) {
            $transactionRequest->setCertificateType($data['certificateType']);
        }*/
        if (array_key_exists('language', $data) && !empty($data['language'])) {
            $transactionRequest->setLanguage($data['language']);
        }
        if (array_key_exists('handwrittenSignatureMode', $data) && !empty($data['handwrittenSignatureMode'])) {
            $transactionRequest->setHandwrittenSignatureMode($data['handwrittenSignatureMode']);
        }
        if (array_key_exists('chainingMode', $data) && !empty($data['chainingMode'])) {
            $transactionRequest->setChainingMode($data['chainingMode']);
        }
        if (array_key_exists('finalDocCCeMails', $data) && !empty($data['finalDocCCeMails'])) {
            $transactionRequest->setFinalDocCCeMails($data['finalDocCCeMails']);
        }
        if (array_key_exists('autoValidationRedirection', $data) && array_key_exists('URL', $data['autoValidationRedirection']) && !empty($data['autoValidationRedirection']['URL'])) {
            $transactionRequest->setAutoValidationURL($data['autoValidationRedirection']);
        }
        if (array_key_exists('redirectPolicy', $data) && !empty($data['redirectPolicy'])) {
            $transactionRequest->setRedirectPolicy($data['redirectPolicy']);
        }
        if (array_key_exists('redirectWait', $data) && !empty($data['redirectWait'])) {
            $transactionRequest->setRedirectWait($data['redirectWait']);
        }
        if (array_key_exists('autoSendAgreements', $data) && !empty($data['autoSendAgreements'])) {
            $transactionRequest->setAutoSendAgreements($data['autoSendAgreements']);
        }
        if (array_key_exists('operator', $data) && !empty($data['operator'])) {
            $transactionRequest->setOperator($data['operator']);
        }
        if (array_key_exists('registrationCallbackURL', $data) && !empty($data['registrationCallbackURL'])) {
            $transactionRequest->setRegistrationCallbackURL($data['registrationCallbackURL']);
        }
        if (array_key_exists('successRedirection', $data) && array_key_exists('URL', $data['successRedirection']) && !empty($data['successRedirection']['URL'])) {
            $transactionRequest->setSuccessRedirection($data['successRedirection']);
        }
        if (array_key_exists('cancelRedirection', $data) && array_key_exists('URL', $data['cancelRedirection']) && !empty($data['cancelRedirection']['URL'])) {
            $transactionRequest->setCancelRedirection($data['cancelRedirection']);
        }
        if (array_key_exists('failRedirection', $data) && array_key_exists('URL', $data['failRedirection']) && !empty($data['failRedirection']['URL'])) {
            $transactionRequest->setFailRedirection($data['failRedirection']);
        }

        return $transactionRequest;
    }
}