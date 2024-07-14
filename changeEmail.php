<?php
include "databaseLogIn.php";
session_start();

class changeEmail extends connection{
    
    
    public function change(){
        if(!isset($_POST['token']) || !Token::check($_POST['token'])){
            return;
        }
        
        $email = $_POST['email'];
        
        $query = "UPDATE ".$this->database.".clients SET email = ? where username= ?";
        $res = $this->connect()->prepare($query);
        $res->execute([$email, $_SESSION['user']]);
    }
}

$myClass = new changeEmail();
$myClass->change();
header("Location:profilePage.php");

?>