<!doctype html>
<?php
    require_once 'Model/Post.php';
    require_once 'Model/Gebruiker.php';
    require_once 'DAO/PostDAO.php';
    require_once 'DAO/GebruikerDAO.php';
    
    // redirect
    if(!isset($_COOKIE['GebruikerId'])){
        header("location:login.php");
    }
   
    $gebruiker = GebruikerDAO::getGebruikerById($_COOKIE['GebruikerId']);
    $gebruikerId = $inhoud = "";
    
    if(isPostAangemaakt()) {
        $gebruikerId = $gebruiker->getGebruikerId();
        $inhoud = $_POST["inhoud"];
        PostDAO::voegPostToe(new Post(0,$gebruikerId,$inhoud));
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
        
        <main id="index">
            <aside id="profileInfo">
                <img src="<?php echo $gebruiker->getLocatieFoto(); ?>">
                <p><?php echo $gebruiker->getVolledigeNaam(); ?> (<?php echo $gebruiker->getLoginnaam(); ?>)</p>
                <form action="logout.php" method="POST">
                    <input type="hidden" name="postcheck" value="true"/>
                    <input type="submit" value="Logout"/>
                </form>
            </aside>
            
            <div id="middleSection">
                <section>
                    <form action="index.php" method="POST">
                        <input type="text" name="inhoud" placeholder="What are your cat-thoughts?">
                        <input type="hidden" name="postcheck" value="true"/>
                        <input type="submit" value="Post">
                    </form>
                </section>
            
                <article id="feed">
                    <ul>
                        <?php
                            foreach(PostDAO::getPosts() as $post){
                                $gebruiker = GebruikerDAO::getGebruikerById($post->getGebruikerId())
                        ?>
                        <li class="post">
                            <img src="<?php echo $gebruiker->getLocatieFoto() ?>">
                            <p class="userName"><?php echo $gebruiker->getLoginnaam() ?></p>
                            <p class="postContents"><?php echo $post->getInhoud() ?></p>  
                        </li>
                        <?php
                            }
                        ?>
                    </ul>
                </article>
            </div>
            
            <aside id="advertisements">
            <!--EXPANSION SPACE FOR EXRTA CONTENT-->
            </aside>
            
        </main>
    
        <footer>
        
        </footer>
    </div>
</body>
</html>

<?php     
     function isPostAangemaakt() {
        return isset($_POST['postcheck']);
    }
?>