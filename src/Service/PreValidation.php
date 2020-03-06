<?php

namespace App\Service;

use GuzzleHttp\Client;

class PreValidation
{
    private $uri;
    private $xmlrpcResult;
    /**
     * PreValidation constructor.
     * @param string $uri url d'appel du service
     */
    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    public function validate($params)
    {
        $client = new Client([
            'base_uri'  => '',
            'timeout'   => 200.0,
            'verify'    => false,
        ]);
        $response = $client->request('GET', $this->uri, ['body' => xmlrpc_encode_request('validator.validate',$params)]);
        $this->xmlrpcResult = xmlrpc_decode($response->getBody()->getContents());
    }
}