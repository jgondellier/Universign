<?php

namespace App\Service;

use GuzzleHttp\Client;
use http\Exception\InvalidArgumentException;

class PreValidation
{
    private $uri;
    private $xmlrpcResult;
    private $result;
    private $reason;
    private $id;
    private $status;
    private $explanation;

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

        if(!isset($data['birthdate']) || !isset($data['firstname']) || !isset($data['lastname']) || !isset($data['type']) || !isset($data['cni1']) ){
            throw new \InvalidArgumentException('Un parametre est manquant.');
        }

        $photos=array();
        if(isset($data['cni1'])){
            $cni1  = file_get_contents($data['cni1']);
            xmlrpc_set_type($cni1,'base64');
            $photos[]=$cni1;
        }else{
            throw new \InvalidArgumentException('Une CNI doit être fourni.');
        }
        if(isset($data['cni2'])){
            $cni2  = file_get_contents($data['cni2']);
            xmlrpc_set_type($cni2,'base64');
            $photos[]=$cni2;
        }
        $birthDate = date_format($data['birthdate'],'Ymd').'T'.date_format($data['birthdate'],'h:m:s');
        xmlrpc_set_type($birthDate,'datetime');
        $params=array(
            'idDocument'=>array(
                'photos'=>$photos,
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
            'body' => xmlrpc_encode_request('validator.validate',$params)
        ]);
        $this->xmlrpcResult = xmlrpc_decode($response->getBody()->getContents());
        $this->result = $this->xmlrpcResult['result'];
        $this->reason = $this->xmlrpcResult['reason'];
        $this->id = $this->xmlrpcResult['id'];
        $this->status = $this->xmlrpcResult['status'];

    }
    public function getValidationResult()
    {
        switch ($this->status) {
            case 0:
                $this->explanation='En cours';
                break;
            case 1:
                $this->explanation='Validé';
                break;
            case 2:
                $this->explanation='Refusé';
                break;
        }
    }
}