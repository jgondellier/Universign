<?php

namespace App\Util;

use Gondellier\UniversignBundle\Classes\Request\TransactionDocument;

class TransactionDocumentDataTool
{
    public function setData(array $data):TransactionDocument
    {
        $transactionDocument = new TransactionDocument();
        if(array_key_exists('content',$data)){
            $transactionDocument->setContent($data['content']);
        }
        if(array_key_exists('url',$data)){
            $transactionDocument->setUrl($data['url']);
        }
        if(array_key_exists('name',$data)){
            $transactionDocument->setFileName($data['name']);
        }
        if(array_key_exists('checkBoxTexts',$data)){
            $transactionDocument->setCheckBoxTexts($data['checkBoxTexts']);
        }
        if(array_key_exists('metaData',$data)){
            $transactionDocument->setMetaData($data['metaData']);
        }

        return $transactionDocument;
    }
}