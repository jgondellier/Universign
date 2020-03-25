<?php

namespace App\Util;

use Gondellier\UniversignBundle\Classes\Request\TransactionDocument;

class TransactionDocumentDataTool
{
    public function setData(array $documents): array
    {
        $docSignatureFieldDataTool = new DocSignatureFieldDataTool();
        $transactionDocuments = array();
        foreach ($documents as $document) {
            $transactionDocument = new TransactionDocument();
            if (array_key_exists('content', $document) && !empty($document['content'])) {
                $transactionDocument->setContent($document['content']);
            }
            if (array_key_exists('url', $document) && !empty($document['url'])) {
                $transactionDocument->setUrl($document['url']);
            }
            if (array_key_exists('documentType', $document) && !empty($document['documentType'])) {
                $transactionDocument->setDocumentType($document['documentType']);
            }
            if (array_key_exists('fileName', $document) && !empty($document['fileName'])) {
                $transactionDocument->setFileName($document['fileName']);
            }
            if (array_key_exists('signatureFields', $document) && array_key_exists('docsignature', $document['signatureFields'])) {
                $transactionDocument->setSignatureFields($docSignatureFieldDataTool->setData($document['signatureFields']['docsignature']));
            }

            if (array_key_exists('checkBoxTexts', $document) && array_key_exists('listcheckBoxTexts', $document['checkBoxTexts'])) {
                $checkBoxTexts = array();
                foreach ($document['checkBoxTexts']['listcheckBoxTexts'] as $listcheckBoxTexts) {
                    if (array_key_exists('checkBoxTexts', $listcheckBoxTexts)) {
                        $checkBoxTexts[] = $listcheckBoxTexts['checkBoxTexts'];
                    }
                }
                $transactionDocument->setCheckBoxTexts($checkBoxTexts);
            }
            if (array_key_exists('metaData', $document) && !empty($document['metaData'])) {
                $transactionDocument->setMetaData($document['metaData']);
            }
            //$transactionDocument->check();
            $transactionDocuments[] = $transactionDocument;
        }

        return $transactionDocuments;
    }
}