<?php
// Bron van de validatiebibliotheek is uit VoorbeeldDatabase (SimpelePostMetValidatie)
// Enige functionaliteit toegevoegd, maar de meerderheid is geschreven door dhr. Maarten Heylen
// Credits: Maarten Heylen

require_once 'DAO/GebruikerDAO.php';

function getVeldWaarde($naamVeld) {
    return $_POST[$naamVeld];
}

//Logische tests
function isVeldLeeg($naamVeld) {
    $waarde = getVeldWaarde($naamVeld);
    return empty($waarde);
}

function isVeldGroterDan($naamVeld, $waarde) {
    return (getVeldWaarde($naamVeld) > $waarde);
}
function ligtVeldTussen($naamVeld, $waarde1, $waarde2) {
    return (getVeldWaarde($naamVeld) >= $waarde1 && getVeldWaarde($naamVeld) <= $waarde2);
}
function isVeldNumeriek($naamVeld) {
    return is_numeric(getVeldWaarde($naamVeld));
}

function zijnVeldenEqual($naamVeld1, $naamVeld2) {
    return getVeldWaarde($naamVeld1) == getVeldWaarde($naamVeld2);
}

function errWachtwoordCheck($naamWachtwoordVeld, $naamWachtwoordCheckVeld) {
    if (isVeldLeeg($naamWachtwoordCheckVeld)) {
        return "Gelieve het wachtwoord nogmaals in te geven";
    } else {
        if(zijnVeldenEqual($naamWachtwoordVeld, $naamWachtwoordCheckVeld)) {
            return "";
        }
        return "De wachtwoorden komen niet overeen";
    }
}

//Error message generatie
function errRequiredVeld($naamVeld) {
    if (isVeldLeeg($naamVeld)) {
        return "Gelieve een waarde in te geven";
    } else {
        return "";
    }
}

function errLoginnaam($naamVeld) {
    if (isVeldLeeg($naamVeld)) {
        return "Gelieve een waarde in te geven";
    } else {
        if(GebruikerDAO::doesLoginnaamExists(getVeldWaarde($naamVeld))) {
            return "Deze loginnaam is al in gebruik. Kies een andere.";
        }
        return "";
    }
}

function errGeboortedatum($naamVeldDag, $naamVeldMaand, $naamVeldJaar) {
    if (isVeldLeeg($naamVeldDag)||isVeldLeeg($naamVeldMaand)||isVeldLeeg($naamVeldJaar)) {
        return "Gelieve waardes in te vullen";
    } else {
        if (isVeldNumeriek($naamVeldDag) && isVeldNumeriek($naamVeldMaand) && isVeldNumeriek($naamVeldJaar)) {
            if (ligtVeldTussen($naamVeldDag, 1, 31)&& ligtVeldTussen($naamVeldMaand, 1, 12) && ligtVeldTussen($naamVeldJaar, 1850, date("Y"))) {
                return "";
            }
            return "Gelieve een geldige datum in te geven: dag tussen 1 en 31, maand tussen 1 en 12, jaar tussen 1850 en huidig jaar";
        }
        return "Gelieve geldige nummers in te vullen";
    }
}

function errVeldMoetGroterDanWaarde($naamVeld, $waarde) {
    if (isVeldGroterDan($naamVeld, $waarde)) {
        return "";
    } else {
        return "Waarde moet groter zijn dan " . $waarde . ".";
    }
}

function errVeldIsNumeriek($naamVeld) {
    if (isVeldNumeriek($naamVeld)) {
        return "";
    } else {
        return "Waarde moet numeriek zijn";
    }
}

function errVoegMeldingToe($huidigeErrMelding, $toeTeVoegenErrMelding) {
    if (empty($huidigeErrMelding)) {
        return $toeTeVoegenErrMelding;
    } else {
        if (empty($toeTeVoegenErrMelding)) {
            return $huidigeErrMelding;
        } else {
            return $huidigeErrMelding . "<br>" . $toeTeVoegenErrMelding;
        }
    }
}

function errFoto($naamVeld) {
    if (empty($_FILES[$naamVeld]["name"])) {
        return 'Foto moet ingediend worden';
    } else {
        if($_FILES[$naamVeld]["type"]== "image/jpeg") {
            return "";
        }
        return "Deze file is niet van het type jpg";
    }
}

?>
