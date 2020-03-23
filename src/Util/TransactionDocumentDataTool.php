<?php

namespace App\Util;

use Gondellier\UniversignBundle\Classes\Request\TransactionDocument;

class TransactionDocumentDataTool
{
    public function setData(array $documents): array
    {
        $transactionDocuments = array();
        foreach ($documents as $document) {
            $transactionDocument = new TransactionDocument();
            if (array_key_exists('content', $document) && !empty($document['content'])) {
                $transactionDocument->setContent($document['content']);
            }
            if (array_key_exists('url', $document) && !empty($document['url'])) {
                $transactionDocument->setUrl($document['url']);
            }
            if (array_key_exists('name', $document) && !empty($document['name'])) {
                $transactionDocument->setFileName($document['name']);
            }
            if (array_key_exists('signatureFields', $document) && array_key_exists('docsignature', $document['signatureFields'])) {
                $docSignatureFields = array();
                foreach($document['signatureFields']['docsignature'] as $docSignatureField){
                    /**var DocSignatureField $docSignatureField**/
                    $docSignatureFields[] = $docSignatureField;
                }
                $transactionDocument->setSignatureFields($docSignatureFields);
            }

            if (array_key_exists('checkBoxTexts', $document) && array_key_exists('listcheckBoxTexts', $document['checkBoxTexts'])) {
                $checkBoxTexts = array();
                foreach ($document['checkBoxTexts']['listcheckBoxTexts'] as $checkBoxTexts) {
                    if (array_key_exists('checkBoxTexts', $checkBoxTexts)) {
                        $checkBoxTexts[] = $checkBoxTexts['checkBoxTexts'];
                    }
                }
                $transactionDocument->setCheckBoxTexts($checkBoxTexts);
            }
            if (array_key_exists('metaData', $document) && !empty($document['metaData'])) {
                $transactionDocument->setMetaData($document['metaData']);
            }
            $transactionDocuments[] = $transactionDocument;
        }

        return $transactionDocuments;
    }
}