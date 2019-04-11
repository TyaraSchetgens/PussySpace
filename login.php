<!doctype html>
<?php
    require_once 'Model/Gebruiker.php';
    require_once 'DAO/GebruikerDAO.php';

    if(isset($_COOKIE['GebruikerId'])){
        header("location:index.php");
    }
    
    $loginErr = "";
    $loginnaamVal = $wachtwoordVal = "";

    if (isFormulierIngediend()) {
        if (zoekGebruiker()) {
            header("location:index.php");
        } else {
            $loginnaamVal = $_POST['loginnaam'];
            $wachtwoordVal = $_POST['wachtwoord'];
            $loginErr = "Username or password not found.";
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
         
        <main id="loginPage">
            <section id="middleSection">
                <img src="img/logoWebsite.png">
                <form action="login.php" method="POST">
                    <input type="text" name="loginnaam" placeholder="username" value="<?php echo $loginnaamVal; ?>"/> <br>
                    <input type="password" name="wachtwoord" placeholder="password" value="<?php echo $wachtwoordVal; ?>"/> <br>
                    <input type="hidden" name="postcheck" value="true"/>
                    <input type="submit" value="Let's go!"/>
                    <mark><?php echo $loginErr; ?></mark>
                </form>
                <p>Don't have an account? <br> <a href="registreer.php">register now!</a></p>
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
    /*function zoekGebruiker() {
        
        $loginnaam = $_POST['loginnaam'];
        $wachtwoord = $_POST['wachtwoord'];
        
        return GebruikerDAO::controleerGebruiker($loginnaam, $wachtwoord); //ofwel een ID; ofwel false
            
    }*/
    function zoekGebruiker() {
        
        $loginnaam = $_POST['loginnaam'];
        $wachtwoord = $_POST['wachtwoord'];
        
        if(!empty($loginnaam) && !empty($wachtwoord)) {
            //$gebruiker = GebruikerDAO::getGebruikerById($loginnaam);
            $gebruikerId = GebruikerDAO::controleerGebruiker($loginnaam,$wachtwoord);
            
            if($gebruikerId){
                maakCookie($gebruikerId);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function maakCookie($gebruikerId) {
        setcookie('GebruikerId', $gebruikerId, time()+60*60*24*30);
    }
?>