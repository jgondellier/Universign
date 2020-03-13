<?php

namespace Gondellier\UniversignBundle\Classes\Request;

class RegistrationRequest
{
    private const TYPE_ID_CARD_FR       = 'id_card_fr';
    private const TYPE_PASSPORT_EU      = 'passport_eu';
    private const TYPE_TITRE_SEJOUR     = 'titre_sejour';
    private const TYPE_DRIVE_LICENSE    = 'drive_license';

    private $documents = array();
    private $type;
}