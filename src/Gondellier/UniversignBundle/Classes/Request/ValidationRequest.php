<?php

namespace Gondellier\UniversignBundle\Classes\Request;

class ValidationRequest
{
    private $idDocument;
    private $personalInfo;
    private $allowManual;
    private $callbackURL;


    /**
     * @return array
     */
    public function getArray():array
    {
        return array('idDocument'=>$this->idDocument,'personalInfo'=>$this->personalInfo,'allowManual'=>$this->allowManual,'callbackURL'=>$this->callbackURL);
    }

    /**
     * @return array
     */
    public function getIdDocument():array
    {
        return $this->idDocument;
    }

    /**
     * @param IdDocument $idDocument
     */
    public function setIdDocument(IdDocument $idDocument): void
    {
        $this->idDocument = $idDocument->getArray();
    }

    /**
     * @return Array
     */
    public function getPersonalInfo():Array
    {
        return $this->personalInfo;
    }

    /**
     * @param PersonalInfo $personalInfo
     */
    public function setPersonalInfo(PersonalInfo $personalInfo): void
    {

        $this->personalInfo = $personalInfo->getArray();
    }

    /**
     * @return bool
     */
    public function getAllowManual():bool
    {
        return $this->allowManual;
    }

    /**
     * Si paramètre a False alors la validation ne se fera que par un robot sans faire appel a un humain
     *
     * @param bool $allowManual
     */
    public function setAllowManual(bool $allowManual): void
    {
        $this->allowManual = $allowManual;
    }

    /**
     * @return string
     */
    public function getCallbackURL():string
    {
        return $this->callbackURL;
    }

    /**
     * @param string $callbackURL
     */
    public function setCallbackURL(string $callbackURL): void
    {
        $this->callbackURL = $callbackURL;
    }


}