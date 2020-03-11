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

    public function validate($data)
    {
        $client = new Client([
            'base_uri'  => '',
            'timeout'   => 200.0,
            'verify'    => false,
        ]);


        /*$urlTest ="https://api.test.universign.eu/v1/prevalidate";
        $responseTest = $client->request('POST', $urlTest, ['auth' =>  ['apikey_7AlYWEx66P119SVeW9Y2PK89v', '']]);
        var_dump($responseTest);exit;*/

        $cni1  = file_get_contents($data['cni1']);
        xmlrpc_set_type($cni1,'base64');
        $cni2  = file_get_contents($data['cni2']);
        xmlrpc_set_type($cni2,'base64');
        $birthDate = date_format($data['birthdate'],'Ymd').'T'.date_format($data['birthdate'],'h:m:s');
        xmlrpc_set_type($birthDate,'datetime');
        $params=array(
            'idDocument'=>array(
                'photos'=>array(
                    $cni1,
                    $cni2
                ),
                'type'=>$data['type']
            ),
            'personalInfo'=>array(
                'firstname'=>$data['firstname'],
                'lastname'=>$data['lastname'],
                'birthDate'=>$birthDate
            ),
            'allowManual'=>False,
          //  'CallbackUrl'=>''
        );

        $response = $client->request('POST', $this->uri, [
            'body' => xmlrpc_encode_request('validator.validate',$params)]);
        $this->xmlrpcResult = xmlrpc_decode($response->getBody()->getContents());

    }
}