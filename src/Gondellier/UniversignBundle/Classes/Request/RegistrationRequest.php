<?php

namespace Gondellier\UniversignBundle\Classes\Request;

class RegistrationRequest
{
    private const TYPE_ID_CARD_FR       = 'id_card_fr';
    private const TYPE_PASSPORT_EU      = 'passport_eu';
    private const TYPE_TITRE_SEJOUR     = 'titre_sejour';
    private const TYPE_DRIVE_LICENSE    = 'drive_license';

    private $documents = array();
    private $type;

    /**
     * @return array
     */
    public function getArray():array
    {
        return array('document'=>$this->documents,'type'=>$this->type);
    }

    /**
     * Verify if the number of doc is the same as expected.
     *
     * @return bool
     */
    public function verifyTypeWithDocuments():bool
    {
        //Controle if 2 docs are upload
        if($this->type === self::TYPE_ID_CARD_FR || $this->type === self::TYPE_TITRE_SEJOUR){
            if (count($this->documents) !== 2){
                return False;
            }
        }else if (count($this->documents) !== 1){
            return False;
        }
        return True;
    }

    /**
     * @return array
     */
    public function getDocuments():array
    {
        return $this->documents;
    }

    /**
     * @param array $documents
     */
    public function setDocuments(array $documents): void
    {
        $this->documents = $documents;
    }

    public function addDocuments(string $documentsPath):void
    {
        $documentsContent  = file_get_contents($documentsPath);
        xmlrpc_set_type($documentsContent,'base64');
        $this->documents[] = $documentsContent;
    }

    /**
     * @return string
     */
    public function getType():string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        if($type !== self::TYPE_ID_CARD_FR &&
            $type !== self::TYPE_PASSPORT_EU &&
            $type !== self::TYPE_TITRE_SEJOUR &&
            $type !== self::TYPE_DRIVE_LICENSE){
            Throw new \InvalidArgumentException('The type must be '.self::TYPE_ID_CARD_FR.' or '.self::TYPE_PASSPORT_EU.' or '.self::TYPE_TITRE_SEJOUR.' or '.self::TYPE_DRIVE_LICENSE);
        }
        $this->type = $type;
    }
}