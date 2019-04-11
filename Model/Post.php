<?php
class Post{
    private $postId;        // int  PK
    private $gebruikerId;   // int
    private $inhoud;        // varchar
    
    //GETTERS
    function getPostId() {
        return $this->postId;
    }
    function getGebruikerId() {
        return $this->gebruikerId;
    }
    function getInhoud() {
        return $this->inhoud;
    }

    // SETTERS
    function setPostId($postId) {
        $this->postId = $postId;
    }
    function setGebruikerId($gebruikerId) {
        $this->gebruikerId = $gebruikerId;
    }
    function setInhoud($inhoud) {
        $this->inhoud = $inhoud;
    }

    // CONSTRUCTOR
    function __construct($postId, $gebruikerId, $inhoud) {
        $this->postId = $postId;
        $this->gebruikerId = $gebruikerId;
        $this->inhoud = $inhoud;
    }
} 
?>