<?php
include "databaseLogIn.php";
session_start();

class changeName extends connection{
    
    
    public function check($name){
        
        if(!isset($_POST['token']) || !Token::check($_POST['token'])){
            return;
        }
        
        $query = "SELECT * from ".$this->database.".clients where username = ?";
        $run = $this->connect()->prepare($query);
        $run->execute([$name]);
        $count = $run->rowCount();
        if($count > 0){
            echo "<script>alert('The username is already taken');</script>";
            return true;
        }
        return false;
    }
    
    public function change(){
        
        if(!isset($_POST['token']) || !Token::check($_POST['token'])){
            return;
        }
        
        $name = $_POST['name'];
        $query = "SELECT extension from handouts.clients where username=?";
        $run=$this->connect()->prepare($query);
        $run->execute([$_SESSION['user']]);
        $ext ="null";
        while($item = $run->fetch()){
            $ext=$item['extension'];
        }
        $path = "Profile Pictures/".$_SESSION['user'].".".$ext;
        if($this->check($name)){
            return;
        }
        $query = "UPDATE handouts.clients SET username = ? where username= ?";
        $res = $this->connect()->prepare($query);
        $res->execute([$name, $_SESSION['user']]);
        $_SESSION['user'] = $name;
        
        if(file_exists($path)){
            $newPath = "Profile Pictures/".$_SESSION['user'].".".$ext;
            rename($path,$newPath);
        }
    }
}
$myClass = new changeName();
$myClass->change();

echo "<script>window.open('profilePage.php', '_self')</script>";

?>