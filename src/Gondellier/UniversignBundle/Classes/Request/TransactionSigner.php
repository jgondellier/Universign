<?php

namespace Gondellier\UniversignBundle\Classes\Request;

class TransactionSigner
{
    private const ROLE_SIGNER                   = 'Signer';
    private const ROLE_OBSERVER                 = 'Observer';
    private const CERTIFICATE_TYPE_LOCAL        = 'local';
    private const CERTIFICATE_TYPE_SIMPLE       = 'simple';
    private const CERTIFICATE_TYPE_CERTIFIED    = 'certified';
    private const CERTIFICATE_TYPE_ADVANCED     = 'advanced';

    private $firstname;
    private $lastname;
    private $organization;
    private $profile;
    private $emailAddress;
    private $phoneNum;
    private $language;
    private $role;
    private $birthDate;
    private $universignId;
    private $successRedirection;
    private $cancelRedirection;
    private $failRedirection;
    private $certificateType;
    private $idDocuments;
    private $validationSessionId;
    private $redirectPolicy;
    private $redirectWait;
    private $autoSendAgreements;


    public function getTestArray(){
        var_dump(get_object_vars($this));
    }

    /**
     * @return array
     */
    public function getArray():array
    {
        return array('firstname'=>$this->firstname,
            'lastname'=>$this->lastname,
            'organization'=>$this->organization,
            'profile'=>$this->profile,
            'emailAddress'=>$this->emailAddress,
            'phoneNum'=>$this->phoneNum,
            'language'=>$this->language,
            'role'=>$this->role,
            'birthDate'=>$this->birthDate,
            'universignId'=>$this->universignId,
            'successRedirection'=>$this->successRedirection,
            'cancelRedirection'=>$this->cancelRedirection,
            'failRedirection'=>$this->failRedirection,
            'certificateType'=>$this->certificateType,
            'idDocuments'=>$this->idDocuments,
            'validationSessionId'=>$this->validationSessionId,
            'redirectPolicy'=>$this->redirectPolicy,
            'redirectWait'=>$this->redirectWait,
            'autoSendAgreements'=>$this->autoSendAgreements
        );
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
    public function getOrganization():string
    {
        return $this->organization;
    }

    /**
     * @param string $organization
     */
    public function setOrganization(string $organization): void
    {
        $this->organization = $organization;
    }

    /**
     * @return string
     */
    public function getProfile():string
    {
        return $this->profile;
    }

    /**
     * @param string $profile
     */
    public function setProfile(string $profile): void
    {
        $this->profile = $profile;
    }

    /**
     * @return string
     */
    public function getEmailAddress():string
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     */
    public function setEmailAddress(string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return string
     */
    public function getPhoneNum():string
    {
        return $this->phoneNum;
    }

    /**
     * @param string $phoneNum
     */
    public function setPhoneNum(string $phoneNum): void
    {
        $this->phoneNum = $phoneNum;
    }

    /**
     * @return string
     */
    public function getLanguage():string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getRole():string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
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

    /**
     * @return string
     */
    public function getUniversignId():string
    {
        return $this->universignId;
    }

    /**
     * @param string $universignId
     */
    public function setUniversignId(string $universignId): void
    {
        $this->universignId = $universignId;
    }

    /**
     * @return RedirectionConfig
     */
    public function getSuccessRedirection():RedirectionConfig
    {
        return $this->successRedirection;
    }

    /**
     * @param RedirectionConfig $successRedirection
     */
    public function setSuccessRedirection(RedirectionConfig $successRedirection): void
    {
        $this->successRedirection = $successRedirection;
    }

    /**
     * @return RedirectionConfig
     */
    public function getCancelRedirection():RedirectionConfig
    {
        return $this->cancelRedirection;
    }

    /**
     * @param RedirectionConfig $cancelRedirection
     */
    public function setCancelRedirection(RedirectionConfig $cancelRedirection): void
    {
        $this->cancelRedirection = $cancelRedirection;
    }

    /**
     * @return RedirectionConfig
     */
    public function getFailRedirection():RedirectionConfig
    {
        return $this->failRedirection;
    }

    /**
     * @param RedirectionConfig $failRedirection
     */
    public function setFailRedirection($failRedirection): void
    {
        $this->failRedirection = $failRedirection;
    }

    /**
     * @return string
     */
    public function getCertificateType():string
    {
        return $this->certificateType;
    }

    /**
     * @param string $certificateType
     */
    public function setCertificateType(string $certificateType): void
    {
        if($certificateType !== self::CERTIFICATE_TYPE_LOCAL &&
            $certificateType !== self::CERTIFICATE_TYPE_SIMPLE &&
            $certificateType !== self::CERTIFICATE_TYPE_CERTIFIED &&
            $certificateType !== self::CERTIFICATE_TYPE_ADVANCED ){
            Throw new \InvalidArgumentException('The certificate value must be : '.self::CERTIFICATE_TYPE_LOCAL.' or '.self::CERTIFICATE_TYPE_SIMPLE.' or '.self::CERTIFICATE_TYPE_CERTIFIED.' or '.self::CERTIFICATE_TYPE_ADVANCED);
        }
        $this->certificateType = $certificateType;
    }

    /**
     * @return RegistrationRequest
     */
    public function getIdDocuments(): RegistrationRequest
    {
        return $this->idDocuments;
    }

    /**
     * @param RegistrationRequest $idDocuments
     */
    public function setIdDocuments(RegistrationRequest $idDocuments): void
    {
        $this->idDocuments = $idDocuments;
    }

    /**
     * @return string
     */
    public function getValidationSessionId():string
    {
        return $this->validationSessionId;
    }

    /**
     * @param string $validationSessionId
     */
    public function setValidationSessionId(string $validationSessionId): void
    {
        $this->validationSessionId = $validationSessionId;
    }

    /**
     * @return string
     */
    public function getRedirectPolicy():string
    {
        return $this->redirectPolicy;
    }

    /**
     * @param string $redirectPolicy
     */
    public function setRedirectPolicy(string $redirectPolicy): void
    {
        $this->redirectPolicy = $redirectPolicy;
    }

    /**
     * @return int
     */
    public function getRedirectWait():int
    {
        return $this->redirectWait;
    }

    /**
     * @param int $redirectWait
     */
    public function setRedirectWait(int $redirectWait): void
    {
        $this->redirectWait = $redirectWait;
    }

    /**
     * @return bool
     */
    public function getAutoSendAgreements():bool
    {
        return $this->autoSendAgreements;
    }

    /**
     * @param bool $autoSendAgreements
     */
    public function setAutoSendAgreements(bool $autoSendAgreements): void
    {
        $this->autoSendAgreements = $autoSendAgreements;
    }

}