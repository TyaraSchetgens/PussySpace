<?php 
require_once 'Model/Post.php';
require_once 'DAO/Verbinding/DatabaseFactory.php';

class PostDAO {
    
    private static function getVerbinding() {
        return DatabaseFactory::getDatabase();
    }

    public static function getPosts() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Post ORDER BY postId DESC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarObject($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
        
    }

    public static function getPostById($postId) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Post WHERE postId=?", array($postId));
        if ($resultaat->num_rows == 1) {
            $databaseRij = $resultaat->fetch_array();
            return self::converteerRijNaarObject($databaseRij);
        } else {
            //Er is waarschijnlijk iets mis gegaan
            return false;
        }
    }

    public static function voegPostToe($post) {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Post(gebruikerId, inhoud) VALUES ('?','?')", array($post->getGebruikerId(), $post->getInhoud()));
    }

    public static function updatePost($post) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Post SET(gebruikerId='?', inhoud='?' WHERE postId=?", array($post->getGebruikerId(), $post->getInhoud(), $post->getPostId()));
    }
    
    public static function verwijderPost($postId) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Post where postId=?", array($postId));
    }

    protected static function converteerRijNaarObject($databaseRij) {
        return new Post($databaseRij['postId'], $databaseRij['gebruikerId'], $databaseRij['inhoud']);
    }
}