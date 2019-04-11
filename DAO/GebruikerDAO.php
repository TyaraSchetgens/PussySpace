<?php 
require_once 'Model/Gebruiker.php';
require_once 'DAO/Verbinding/DatabaseFactory.php';

class GebruikerDAO {
    
    private static function getVerbinding() {
        return DatabaseFactory::getDatabase();
    }

    public static function getGebruikers() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Gebruiker");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarObject($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
        
    }

    public static function getGebruikerById($gebruikerId) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Gebruiker WHERE gebruikerId=?", array($gebruikerId));
        if ($resultaat->num_rows == 1) {
            $databaseRij = $resultaat->fetch_array();
            return self::converteerRijNaarObject($databaseRij);
        } else {
            //Er is waarschijnlijk iets mis gegaan
            return false;
        }
    }

    public static function doesLoginnaamExists($loginnaam) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Gebruiker WHERE loginnaam='?'", array($loginnaam));
        if ($resultaat->num_rows == 1) {
            //Gebruiker exists
            return true;
        } else {
            //Gebruiker does not exist
            return false;
        }
    }
    
    public static function controleerGebruiker($loginnaam, $wachtwoord) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Gebruiker WHERE loginnaam='?'", array($loginnaam));
        if ($resultaat->num_rows == 1) {
            $databaseRij = $resultaat->fetch_array();
            $gevondenGebruiker = self::converteerRijNaarObject($databaseRij);
            if($gevondenGebruiker->getWachtwoord() == $wachtwoord) {
                //Wachtwoord komt overeen
                return $gevondenGebruiker->getGebruikerId();
            } else {
                //Wachtwoord komt niet overeen
                return false;
            }
        } else {
            //Gebruiker niet gevonden
            return false;
        }
    }
    
    public static function voegGebruikerToe($gebruiker) {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Gebruiker(voornaam, achternaam, loginnaam, wachtwoord, geboortedatum, geslacht, locatieFoto) VALUES ('?','?','?','?','?','?','?')", array($gebruiker->getVoornaam(), $gebruiker->getAchternaam(), $gebruiker->getLoginnaam(), $gebruiker->getWachtwoord(), $gebruiker->getGeboortedatum(), $gebruiker->getGeslacht(), $gebruiker->getLocatieFoto()));
    }

    public static function updateGebruiker($gebruiker) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Gebruiker SET(voornaam='?', achternaam='?', loginnaam='?', wachtwoord='?', geboortedatum='?', geslacht='?', locatieFoto='?' WHERE gebruikerId=?", array($gebruiker->getVoornaam(), $gebruiker->getAchternaam(), $gebruiker->getLoginnaam(), $gebruiker->getWachtwoord(), $gebruiker->getGeboortedatum(), $gebruiker->getGeslacht(), $gebruiker->getLocatieFoto(), $gebruiker->getGebruikerId()));
    }
    
    public static function verwijderGebruiker($gebruikerId) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Gebruiker where gebruikerId=?", array($gebruikerId));
    }

    protected static function converteerRijNaarObject($databaseRij) {
        return new Gebruiker($databaseRij['gebruikerId'], $databaseRij['voornaam'], $databaseRij['achternaam'],$databaseRij['loginnaam'],$databaseRij['wachtwoord'],$databaseRij['geboortedatum'],$databaseRij['geslacht'],$databaseRij['locatieFoto']);
    }
}