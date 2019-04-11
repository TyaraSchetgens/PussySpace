<!doctype html>
<?php
if(isset($_POST['postcheck'])) {
    setcookie('GebruikerId', "", time()-1);
}
header("location:login.php");