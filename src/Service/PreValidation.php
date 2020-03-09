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

        file_put_contents('prevalidBody.txt',['body' => xmlrpc_encode_request('validator.validate',$params)]);


        $response = $client->request('POST', $this->uri, [
            'Content-Type' => 'text/xml; charset=UTF8',
            'body' => xmlrpc_encode_request('validator.validate',$params)]);

        var_dump($response->getHeaders());
        var_dump($response->getBody()->getContents());

        $this->xmlrpcResult = xmlrpc_decode($response->getBody()->getContents());

        var_dump($this->xmlrpcResult);exit;

    }
}