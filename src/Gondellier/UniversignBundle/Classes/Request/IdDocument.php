<?php

namespace Gondellier\UniversignBundle\Classes\Request;

class IdDocument
{
    private const CARTE_NATIONAL_IDENTITE = 0;
    private const PASSEPORT = 1;
    private const PERMIS_SEJOUR = 2;
    private const PERMIS_CONDUIRE_EUROPE = 3;

    private $photos;
    private $type;

    /**
     * @return array
     */
    public function getArray():array
    {
        return array('photos'=>$this->photos,'type'=>$this->type);
    }

    /**
     * @return array
     */
    public function getPhotos():array
    {
        return $this->photos;
    }

    /**
     * @param array $photos
     */
    public function setPhotos(array $photos): void
    {
        $this->photos = $photos;
    }

    public function addPhotos(string $photosPath):void
    {
        $photosContent  = file_get_contents($photosPath);
        xmlrpc_set_type($photosContent,'base64');
        $this->photos[] = $photosContent;
    }

    /**
     * @return int
     */
    public function getType():int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        if($type !== 0 && $type !== 1 && $type !== 2 && $type !== 3){
            Throw new \InvalidArgumentException('The type must be 0,1,2 or 3');
        }
        $this->type = $type;
    }


}