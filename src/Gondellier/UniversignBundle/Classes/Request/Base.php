<?php

namespace Gondellier\UniversignBundle\Classes\Request;

class Base
{
    /**
     * Retroune la liste des propriétés de la class sous forme d'array afin de les convertirs simplement en xmlrpc après
     *
     * @return array
     */
    public function getArray():array
    {
        $listField = get_object_vars($this);
        foreach ($listField as $fieldName => $fieldValue) {
            if (empty($fieldValue)) {
                unset($listField[$fieldName]);
            }
        }
        return $listField;
    }
    /**
     * Regarde dans la requete s'il y a une erreur.
     *
     * @param $originalResult
     * @return FaultResponse|null
     */
    public function checkResponseFault($originalResult): ?FaultResponse
    {
        if(isset($originalResult['faultCode'])) {
            $fault = new FaultResponse();
            $fault->setFaultCode($originalResult['faultCode']);
            $fault->setFaultString($originalResult['faultString']);
            return $fault;
        }
        return null;
    }
}