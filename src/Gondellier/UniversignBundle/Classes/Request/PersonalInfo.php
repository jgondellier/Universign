<?php

namespace Gondellier\UniversignBundle\Classes\Request;

class PersonalInfo
{
    private $firstname;
    private $lastname;
    private $birthDate;

    /**
     * @return array
     */
    public function getArray():array
    {
        return array('firstname'=>$this->firstname,'lastname'=>$this->lastname,'birthDate'=>$this->birthDate);
    }

    /**
     * @return string
     */
    public function getFirstname():string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname():string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getBirthDate():string
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate(\DateTime $birthDate): void
    {
        $date = date_format($birthDate,'Ymd').'T'.date_format($birthDate,'h:m:s');
        xmlrpc_set_type($date,'datetime');
        $this->birthDate = $date;
    }


}