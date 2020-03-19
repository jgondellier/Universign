<?php
namespace App\Util;

use Gondellier\UniversignBundle\Classes\Request\TransactionRequest;

class TransactionRequestDataTool
{
    public function setData($data): TransactionRequest
    {
        $transactionRequest = new TransactionRequest();
        if(array_key_exists('profile',$data)){
            $transactionRequest->setProfile($data['profile']);
        }
        if(array_key_exists('customId',$data)){
            $transactionRequest->setCustomId($data['customId']);
        }
        if(array_key_exists('mustContactFirstSigner',$data)){
            $transactionRequest->setMustContactFirstSigner($data['mustContactFirstSigner']);
        }
        if(array_key_exists('finalDocSent',$data)){
            $transactionRequest->setFinalDocSent($data['finalDocSent']);
        }
        if(array_key_exists('finalDocRequesterSent',$data)){
            $transactionRequest->setFinalDocRequesterSent($data['finalDocRequesterSent']);
        }
        if(array_key_exists('finalDocObserverSent',$data)){
            $transactionRequest->setFinalDocObserverSent($data['finalDocObserverSent']);
        }
        if(array_key_exists('description',$data)){
            $transactionRequest->setDescription($data['description']);
        }
        if(array_key_exists('certificateType',$data)){
            $transactionRequest->setCertificateType($data['certificateType']);
        }
        if(array_key_exists('language',$data)){
            $transactionRequest->setLanguage($data['language']);
        }
        if(array_key_exists('handwrittenSignatureMode',$data)){
            $transactionRequest->setHandwrittenSignatureMode($data['handwrittenSignatureMode']);
        }
        if(array_key_exists('chainingMode',$data)){
            $transactionRequest->setChainingMode($data['chainingMode']);
        }
        if(array_key_exists('finalDocCCeMails',$data)){
            $transactionRequest->setFinalDocCCeMails($data['finalDocCCeMails']);
        }
        if(array_key_exists('autoValidationRedirection',$data)){
            $transactionRequest->setAutoValidationURL($data['autoValidationRedirection']);
        }
        if(array_key_exists('redirectPolicy',$data)){
            $transactionRequest->setRedirectPolicy($data['redirectPolicy']);
        }
        if(array_key_exists('redirectWait',$data)){
            $transactionRequest->setRedirectWait($data['redirectWait']);
        }
        if(array_key_exists('autoSendAgreements',$data)){
            $transactionRequest->setAutoSendAgreements($data['autoSendAgreements']);
        }
        if(array_key_exists('operator',$data)){
            $transactionRequest->setOperator($data['operator']);
        }
        if(array_key_exists('registrationCallbackURL',$data)){
            $transactionRequest->setRegistrationCallbackURL($data['registrationCallbackURL']);
        }
        if(array_key_exists('successRedirection',$data)){
            $transactionRequest->setSuccessRedirection($data['successRedirection']);
        }
        if(array_key_exists('cancelRedirection',$data)){
            $transactionRequest->setCancelRedirection($data['cancelRedirection']);
        }
        if(array_key_exists('failRedirection',$data)){
            $transactionRequest->setFailRedirection($data['failRedirection']);
        }

        return $transactionRequest;
    }
}