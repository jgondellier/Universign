<?php

namespace Gondellier\UniversignBundle\Service;

use Gondellier\UniversignBundle\Classes\Request\FaultResponse;
use GuzzleHttp\Client;

abstract class UniversignRequestService
{
    public $uri;
    public $client;
    public $originalResult;
    public $fault;

    /**
     * MatchAccount constructor.
     * @param string $uri url d'appel du service
     */
    public function __construct($uri)
    {
        $this->uri = $uri;
        $this->client = new Client([
            'base_uri'  => '',
            'timeout'   => 200.0,
            'verify'    => false,
        ]);
    }
    public function checkResponseFault(): void
    {
        if(isset($this->originalResult['faultCode'])) {
            $fault = new FaultResponse();
            $fault->setFaultCode($this->originalResult['faultCode']);
            $fault->setFaultString($this->originalResult['faultString']);
            $this->fault = $fault;
        }
    }
    /**
     * @return array
     */
    public function getOriginalResult():array
    {
        return $this->originalResult;
    }
}