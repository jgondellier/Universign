<?php

namespace Gondellier\UniversignBundle\Service;

use Gondellier\UniversignBundle\Classes\Request\StandaloneRegistration;
use GuzzleHttp\Client;

class StandaloneRegistrationRequestService{
    private $uri;
    private $originalResult;
    private $result;
    private $reason;
    private $id;
    private $status;
    private $explanation;

    /**
     * ValidationRequest constructor.
     * @param string $uri url d'appel du service
     */
    public function __construct($uri)
    {
        $this->uri = $uri;
    }
    public function validate(StandaloneRegistration $StandaloneRegistration)
    {
        $client = new Client([
            'base_uri'  => '',
            'timeout'   => 200.0,
            'verify'    => false,
        ]);

        $response = $client->request('POST', $this->uri.'/sign/rpc/', [
            'body' => xmlrpc_encode_request('requester.requestRegistration',$StandaloneRegistration->getArray())
        ]);
        $this->originalResult = xmlrpc_decode($response->getBody()->getContents());
    }
    /**
     * @return mixed
     */
    public function getOriginalResult()
    {
        return $this->originalResult;
    }
}