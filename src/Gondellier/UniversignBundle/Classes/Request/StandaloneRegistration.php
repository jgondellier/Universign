<?php

namespace Gondellier\UniversignBundle\Classes\Request;

class StandaloneRegistration extends Base
{
    public $profile;
    public $signer;

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile): void
    {
        $this->profile = $profile;
    }

    /**
     * @return mixed
     */
    public function getSigner()
    {
        return $this->signer;
    }

    /**
     * @param TransactionSigner $signer
     */
    public function setSigner(TransactionSigner $signer): void
    {
        $this->signer = $signer->getArray();
    }


}