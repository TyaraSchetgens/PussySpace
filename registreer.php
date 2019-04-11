<!doctype html>
<?php
    date_default_timezone_set('Europe/Brussels');
    require_once 'Model/Gebruiker.php';
    require_once 'DAO/GebruikerDAO.php';
    require_once 'validatiebibliotheek.php';
    
    // For 'remembering' the values in the fields and outputting errors
    $voornaamVal= $achternaamVal=$loginnaamVal=$gdDagVal=$gdMaandVal=$gdJaarVal=$geslachtVal=$wachtwoordVal=$wachtwoordCheckVal= "";
    $voornaamErr= $achternaamErr=$loginnaamErr=$geboortedatumErr=$fotoErr=$geslachtErr=$wachtwoordErr=$wachtwoordCheckErr= "";

    if (isFormulierIngediend()) {
        //hier alle error messages opvullen (validatie toevoegen)            
        
        // NOG HELEMAAL GOED DOEN
        $voornaamErr = errRequiredVeld("voornaam");
        $achternaamErr = errRequiredVeld("achternaam");
        $loginnaamErr = errLoginnaam("loginnaam");
        $wachtwoordErr = errRequiredVeld("wachtwoord");
        $wachtwoordCheckErr = errWachtwoordCheck("wachtwoord", "wachtwoordCheck");
        $geboortedatumErr = errGeboortedatum("gdDag", "gdMaand", "gdJaar");
        $geslachtErr = errRequiredVeld("geslacht");
        $fotoErr = errFoto("foto");

        
        
        if (isFormulierValid()) {
            
            // foto verwerken
            $pathToUploadFolder = 'img/profielfotos';
            if (!is_dir($pathToUploadFolder)) {
                mkdir($pathToFullFolder, 0777, true);
            }
            $target_dir = $pathToUploadFolder . '/';

            $target_file = $target_dir . $_FILES['foto']['name'];
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
            
            
            // $locatieFoto = "img/profielfotos/hallo.png";
            
            // Create new user and insert in database
            $loginnaam = $_POST['loginnaam'];
            $wachtwoord = $_POST['wachtwoord'];
            $geboortedatum = $_POST['gdJaar'] . '-' . $_POST['gdMaand'] . '-' . $_POST['gdDag'];
            $locatieFoto = $target_file;
            
            $gebruiker = new Gebruiker($_POST['gebruikerId'], $_POST['voornaam'], $_POST['achternaam'], $_POST['loginnaam'], $_POST['wachtwoord'], $geboortedatum, $_POST['geslacht'], $locatieFoto);
            GebruikerDAO::voegGebruikerToe($gebruiker);
            
            // cookie aanmaken
            $gebruikerId = GebruikerDAO::controleerGebruiker($loginnaam, $wachtwoord);
            maakCookie($gebruikerId);
            
            header("location:index.php");
        } else {
            $voornaamVal = $_POST['voornaam'];
            $achternaamVal= $_POST['achternaam'];
            $loginnaamVal = $_POST['loginnaam'];
            $gdDagVal = $_POST['gdDag'];
            $gdMaandVal = $_POST['gdMaand'];
            $gdJaarVal = $_POST['gdJaar'];
            $geslachtVal = $_POST['geslacht'];
            $wachtwoordVal = $_POST['wachtwoord'];
            $wachtwoordCheckVal = $_POST['wachtwoordCheck'];
        }
    }
?>
<html>
<head>
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <meta charset="utf-8">
    <title> PussySpace - For Cat Lovers </title>
</head>
<body>
    <div class="wrapper">
        <header>
            <a href="index.php"> 
                <img src="img/pussySpaceLogoSmall.png">
            </a>
        </header>
        
        <main id="registerPage">
            <section id="middleSection">
                <form action="registreer.php" method="POST" enctype="multipart/form-data">
                    <!--VOORNAAM-->
                    <label for="voornaam">Voornaam*:</label><br>
                    <input type="text" name="voornaam" value="<?php echo $voornaamVal;?>"/><br>
                    <mark><?php echo $voornaamErr; ?></mark><br>
                    <br>
                    <!--ACHTERNAAM-->
                    <label for="achternaam">Achternaam*:</label><br>
                    <input type="text" name="achternaam" value="<?php echo $achternaamVal;?>"/><br>
                    <mark><?php echo $achternaamErr; ?></mark><br>
                    <br>
                    <!--LOGINNAAM-->
                    <label for="loginnaam">Loginnaam*:</label><br>
                    <input type="text" name="loginnaam" value="<?php echo $loginnaamVal;?>"/><br>
                    <mark><?php echo $loginnaamErr; ?></mark><br>
                    <br>
                    <!--FIRST-TRY PASWOORD-->
                    <label for="wachtwoord">Wachtwoord*:</label><br>
                    <input type="password" name="wachtwoord" value="<?php echo $wachtwoordVal;?>"><br>
                    <mark><?php echo $wachtwoordErr; ?></mark><br>
                    <br>
                    <!--SECOND-TRY PASWOORD-->
                    <label for="wachtwoordCheck">Voer nogmaals uw wachtwoord in*:</label><br>
                    <input type="password" name="wachtwoordCheck" value="<?php echo $wachtwoordCheckVal;?>"><br>
                    <mark><?php echo $wachtwoordCheckErr; ?></mark><br>
                    <br>
                    <!--GEBOORTEDATUM-->
                    <label for="gd">Geboortedatum*:</label><br>
                    <fieldset name="gd">
                        <!--DAG-->
                        <input type="text" name="gdDag" placeholder="dd" value="<?php echo $gdDagVal;?>"/> /
                        <!--MAAND-->
                        <input type="text" name="gdMaand" placeholder="mm" value="<?php echo $gdMaandVal;?>"/> /
                        <!--JAAR-->
                        <input type="text" name="gdJaar"  placeholder="jjjj" value="<?php echo $gdJaarVal;?>"/><br>
                        <mark><?php echo $geboortedatumErr; ?></mark><br>
                    </fieldset>
                    <br>
                    <!--GESLACHT-->
                    <label for="geslacht">Geslacht*:</label><br>
                    <fieldset>
                        <label for="man"><input type="radio" name="geslacht" value="man" id="man" <?php if($geslachtVal=="man"){ echo "checked";} ?>> Man</label> <br>
                        <label for="vrouw"><input type="radio" name="geslacht" value="vrouw" id="vrouw" <?php if($geslachtVal=="vrouw"){ echo "checked";} ?>> Vrouw </label><br>
                        <label for="kat"><input type="radio" name="geslacht" value="kat" id="kat" <?php if($geslachtVal=="kat"){ echo "checked";} ?>> Kat </label><br>
                        <mark><?php echo $geslachtErr; ?></mark><br>
                    </fieldset>
                    <br>
                    <!--PROFIELFOTO-->
                        <label for="foto">Profielfoto toevoegen*:</label><br>
                        <input type="file" id="foto" name="foto"/><br>
                    <mark><?php echo $fotoErr?></mark><br>
                    <br>

                    <div>
                        <input type="hidden" name="postcheck" value="true"/>
                        <input type="submit" value="Let's miauw!">
                    </div>
                </form>
            </section>
        </main>
    
        <footer>
        
        </footer>
    </div>
</body>
</html>

<?php
function isFormulierIngediend() {
        return isset($_POST['postcheck']);
    }
    
function isFormulierValid() {
    global  $voornaamErr,$achternaamErr,$loginnaamErr,$gdDagErr,$gdMaandErr,$gdJaarErr,$locatieFotoErr,$geslachtErr,$wachtwoordErr;
    $allErr = $voornaamErr . $achternaamErr . $loginnaamErr . $gdDagErr . $gdMaandErr . $gdJaarErr . $locatieFotoErr . $geslachtErr . $wachtwoordErr;
    if (empty($allErr)) {
        //Formulier is valid
        return true;
    } else {
        return false;
    }
}

function maakCookie($gebruikerId) {
        setcookie('GebruikerId', $gebruikerId, time()+60*60*24*30);
    }
?>