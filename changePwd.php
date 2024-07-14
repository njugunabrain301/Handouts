<?php
include "databaseLogIn.php";
session_start();
class changePwd extends connection{
    
    public function change(){
        if(!isset($_POST['token']) || !Token::check($_POST['token'])){
            return;
        }
        
        $new = $_POST['new_pwd'];
        $old = $_POST['old_pwd'];
        $confirm = $_POST['confirm_pwd'];
        $correct = 0;
        @$user = $_SESSION['user'];
            if(isset($user)){
                $query = "select * from ".$this->database.".clients where username =?";
                $executed = $this->connect()->prepare($query);
                $executed->execute([$user]);
                if($executed->rowCount() > 0){
                    while($items = $executed->fetch()){
                        if(password_verify($old,$items['password'])){
                            $correct = 1;
                        }
                    }
                }
            }
        
        if($correct == 0){
            echo "<script>alert('Current password entered is wrong');</script>";       
            return; 
        }
        if($confirm !== $new){
            echo "<script>alert('Passwords do not match');</script>";
            return;
        }
        if(strlen($new) < 6){
            echo "<script>alert('Password must be more than 6 characters');</script>";
            return;
        }
        $query = "UPDATE ".$this->database.".clients SET password = ? where username= ?";
        $res = $this->connect()->prepare($query);
        $res->execute([password_hash($new, PASSWORD_DEFAULT), $_SESSION['user']]);
        echo "<script>alert('Password change successful');</script>";
    }
}
$myClass = new changePwd();
$myClass->change();
echo "<script>window.open('profilePage.php','_self');</script>";

?>