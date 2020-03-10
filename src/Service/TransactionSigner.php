<?php

namespace App\Service;

use GuzzleHttp\Client;

class TransactionSigner
{
    private $uri;
    private $xmlrpcResult;

    /**
     * TransactionSigner constructor.
     * @param string $uri url d'appel du service
     */
    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    public function sign($params)
    {
        $client = new Client([
            'base_uri' => '',
            'timeout' => 200.0,
            'verify' => false,
        ]);
    }
}