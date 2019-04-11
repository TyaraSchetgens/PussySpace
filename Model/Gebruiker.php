<?php
class Gebruiker{
    private $gebruikerId;   //int
    private $voornaam;      // varchar
    private $achternaam;    // varchar
    private $loginnaam;     // varchar
    private $wachtwoord;    // varchar
    private $geboortedatum; // date
    private $geslacht;      // varchar
    private $locatieFoto;   // varchar
    
    
    function getVolledigeNaam() {
        return $this->voornaam . " " .$this->achternaam;
    }
    // GETTERS
    function getGebruikerId() {
        return $this->gebruikerId;
    }
    function getVoornaam() {
        return $this->voornaam;
    }
    function getAchternaam() {
        return $this->achternaam;
    }
    function getLoginnaam() {
        return $this->loginnaam;
    }
    function getWachtwoord() {
        return $this->wachtwoord;
    }
    function getGeboortedatum() {
        return $this->geboortedatum;
    }
    function getGeslacht() {
        return $this->geslacht;
    }
    function getLocatieFoto() {
        return $this->locatieFoto;
    }

    // SETTERS
    function setGebruikerId($gebruikerId) {
        $this->gebruikerId = $gebruikerId;
    }
    function setVoornaam($voornaam) {
        $this->voornaam = $voornaam;
    }
    function setAchternaam($achternaam) {
        $this->achternaam = $achternaam;
    }
    function setLoginnaam($loginnaam) {
        $this->loginnaam = $loginnaam;
    }
    function setWachtwoord($wachtwoord) {
        $this->wachtwoord = $wachtwoord;
    }
    function setGeboortedatum($geboortedatum) {
        $this->geboortedatum = $geboortedatum;
    }
    function setGeslacht($geslacht) {
        $this->geslacht = $geslacht;
    }
    function setLocatieFoto($locatieFoto) {
        $this->locatieFoto = $locatieFoto;
    }

    // CONSTRUCTOR
    function __construct($gebruikerId, $voornaam, $achternaam, $loginnaam, $wachtwoord, $geboortedatum, $geslacht, $locatieFoto) {
        $this->gebruikerId = $gebruikerId;
        $this->voornaam = $voornaam;
        $this->achternaam = $achternaam;
        $this->loginnaam = $loginnaam;
        $this->wachtwoord = $wachtwoord;
        $this->geboortedatum = $geboortedatum;
        $this->geslacht = $geslacht;
        $this->locatieFoto = $locatieFoto;
    }  
}    

?>
