<?php

namespace App\Service;

use GuzzleHttp\Client;
use http\Exception\InvalidArgumentException;

class MatchAccount
{
    private const OBFS='**';
    private $uri;
    private $firstname;
    private $lastname;
    private $email;
    private $mobile;
    private $originalResult;
    private $bestResult=False;
    private $account=False;
    private $partialAccount=False;
    private $isCertified=False;
    private $explanation;

    /**
     * MatchAccount constructor.
     * @param string $uri url d'appel du service
     */
    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Le prenom a rechercher
     *
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * Le nom a rechercher
     *
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * L'email a rechercher
     *
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * Le telephone protable a rechercher
     *
     * @param mixed $mobile
     */
    public function setMobile($mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * Initialise la recherche...
     */
    public function match():void
    {
        $client = new Client([
            'base_uri'  => '',
            'timeout'   => 200.0,
            'verify'    => false,
        ]);

        if(empty($this->firstname) || empty($this->lastname) || empty($this->email) || empty($this->mobile)){
            throw new \InvalidArgumentException('Empty required parameter.');
        }

        $params = array('firstname'=>$this->firstname,'lastname'=>$this->lastname,'email'=>$this->email,'mobile'=>$this->mobile);

        $response = $client->request('GET', $this->uri, ['body' => xmlrpc_encode_request('matcher.matchAccount',$params)]);
        $this->originalResult = xmlrpc_decode($response->getBody()->getContents());
        $this->findBestResult();
        $this->explain();
    }

    /**
     *  Donne le compte trouvé s'il y a unseul résultat et que ca correspond
     *
     * @return bool|array
     */
    private function findAccount()
    {
        if(!empty($this->originalResult) && (count($this->originalResult) === 1) && !in_array(self::OBFS, $this->originalResult, true)) {
            $this->isCertified=$this->isCertified($this->originalResult[0]);
            return  $this->account = $this->originalResult[0];
        }
        return False;
    }

    /**
     * Universign retourne une liste de compte trié par ordre alaphabetique sur les nom et prénom des comptes trouvés.
     * L'unicité d'un compte aujourd'hui est l'email et le telephone.
     * On recherche dans la liste de résultat les plus pertinents.
     */
    private function findBestResult(): void
    {
        if(!$this->findAccount()){
            $bestResult = array();
            if(empty($this->originalResult)){
                return;
            }

            foreach($this->originalResult as $result){
                //On a trouvé l'email
                if(strpos($result['email'],self::OBFS)===False){
                    $bestResult['findEmail']=$result;
                    if(array_key_exists('findMobile',$bestResult)){
                        break;
                    }
                }
                //On a trouvé le mobile
                if(strpos($result['mobile'],self::OBFS)===False){
                    $bestResult['findMobile']=$result;
                    if(array_key_exists('findEmail',$bestResult)){
                        break;
                    }
                }
            }
            //On a trouvé le mail et le mobile dans le meme resultat on a un compte mais PB de prenom et nom
            if(array_key_exists('findEmail',$bestResult) && array_key_exists('findMobile',$bestResult)){
                if($bestResult['findEmail']===$bestResult['findMobile']){
                    $this->isCertified=$this->isCertified($bestResult['findEmail']);
                    $this->partialAccount=$bestResult['findEmail'];
                    return;
                }
            }elseif(array_key_exists('findEmail',$bestResult)){
                $this->bestResult = $bestResult;
            }elseif(array_key_exists('findMobile',$bestResult)){
                $this->bestResult = $bestResult;
            }
        }
    }

    /**
     * Retourne le résultat le plus pertinent.
     *
     * @return array|bool
     */
    public function getBestResult()
    {
        if($this->account){
            return $this->account;
        }
        if($this->partialAccount){
            return $this->partialAccount;
        }
        return $this->bestResult;
    }

    /**
     * Est ce qu'un certificat a été trouvé ?
     *
     * @param array $account
     * @return bool
     */
    private function isCertified(array $account): bool
    {
        return array_key_exists('certificateLevel', $account) && $account['certificateLevel'] === 'certified';
    }

    /**
     * Permet de savoir en fonction du niveau de signature que l'on souhaite si le compte peut signé en l'état.
     *
     * @param int $neededSignLevel Niveau de la signature souhaité
     * @return bool
     */
    public function isValid($neededSignLevel): bool
    {
        switch ($neededSignLevel) {
            case 1:
                //Compte trouvé ou compte trouvé sans prenom et nom mais sans certificat
                if(($this->partialAccount && $this->isCertified===False) || $this->account ){
                    return true;
                }
                break;
            case 2:
                //Compte trouvé et avec certificat
                if($this->account && $this->isCertified){
                    return true;
                }
                break;
        }
        return False;
    }

    /**
     * Trouve une expliquation au résultat trouvé.
     */
    public function explain(): void
    {
        if($this->account && $this->isCertified){
            $this->explanation = 'Aucun problème pour signer n\'importe quelle acte.';
            return;
        }
        if($this->account && !$this->isCertified){
            $this->explanation = 'Attention compte de niveau 1. La CNI pourra être demandée.';
            return;
        }
        if($this->partialAccount && $this->isCertified){
            $explain = 'Compte de niveau 2 mais ';
            if(strpos($this->partialAccount['lastname'],self::OBFS)!==False){
                $explain .= 'le nom ne correspond pas au client ';
            }
            if(strpos($this->partialAccount['firstname'],self::OBFS)!==False){
                $explain .= 'le prénom ne correspond pas au client ';
            }
            $explain .= '. Impossible de signer en niveau 2.';
            $this->explanation = $explain;
            return;
        }
        if($this->partialAccount && !$this->isCertified){
            $this->explanation = 'Compte de niveau 1. Le nom ou le prenom ne correspond pas. Pas de problème pour signer en niveau 1.';
            return;
        }
        if(is_array($this->bestResult)){
            if(array_key_exists('findEmail',$this->bestResult) && array_key_exists('findMobile',$this->bestResult)){
                $this->explanation = 'Deux comptes trouvés. Un avec l\'email et un autre avec le téléphone. L\'association email et mobile doit être unique.';
                return;
            }
            if(array_key_exists('findEmail',$this->bestResult)){
                $this->explanation = 'L\'email demandé a été trouvé mais pas le téléphone.';
                return;
            }
            if(array_key_exists('findMobile',$this->bestResult)){
                $this->explanation = 'Le mobile demandé a été trouvé mais pas l\'email.';
                return;
            }
        }

        if($this->account===False && $this->partialAccount===False && $this->bestResult===False){
            $this->explanation = 'Aucun compte trouvé.';
            return;
        }
    }

    /**
     * @return mixed
     */
    public function getExplanation()
    {
        return $this->explanation;
    }

}