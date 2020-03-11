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
        //Erreur dans l'appel
        if(isset($this->xmlrpcResult['faultCode'])){
            throw new \InvalidArgumentException($this->xmlrpcResult['faultString']);
        }
        $this->result = $this->xmlrpcResult['result'];
        $this->reason = $this->xmlrpcResult['reason'];
        $this->id = $this->xmlrpcResult['id'];
        $this->status = $this->xmlrpcResult['status'];
        $this->traitValidationResult();
    }

    /**
     * Permet d'interpréter la réponse qu'universign a fait.
     *
     */
    private function traitValidationResult():void
    {
        switch ($this->status) {
            case 0:
                $this->explanation[]='En cours';
                break;
            case 1:
                $this->explanation[]='Validé';
                break;
            case 2:
                $this->explanation[]='Refusé';
                switch ($this->reason) {
                    case 4:
                        $this->explanation[]='Lecture impossible de la pièce. Mauvaise qualité ?';
                        break;
                }
                if(is_array($this->result)){
                    foreach ($this->result as $field => $result){
                        if($result['valid']===false){
                            $this->explanation[]='Le champs : '.$field.' on recherche : '.$result['expected'].' mais on a trouvé : '.$result['found'];
                        }
                    }
                }
                break;
        }
    }

    /**
     * @return array le tableau de resultat de l'interpretation de la reponse d'universign
     */
    public function getValidationResult():array
    {
        return $this->explanation;
    }
    /**
     * @return array le résultalt de la requete formaté en array
     */
    public function getRequestResult():array
    {
        return $this->xmlrpcResult;
    }

    /**
     * @return string l'id retourné par universign
     */
    public function getId():string
    {
        return $this->id;
    }

}