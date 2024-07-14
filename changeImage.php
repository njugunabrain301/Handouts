<?php
include "databaseLogIn.php";
session_start();

class changeImage extends connection{
    
    
    public function change(){
        if(!isset($_POST['token']) || !Token::check($_POST['token'])){
            return;
        }
        
        $user = $_SESSION['user'];
        $success = 1;                
        $target_dir = "Profile Pictures/";
        $target_file = $target_dir.basename($_FILES['file']["name"]);
        $ext = strtolower(end(explode('.',$_FILES['file']['name'])));
        $exts = array("jpg", "jpeg","gif","png");
        if($target_file == $target_dir){
            $success = 0;
        }else{
            if(!in_array($ext,$exts)){
                echo "<script>alert('File format not supported.');</script>";
                $success = 0;
            }
            
            if($_FILES['file']['size'] > 26214400){
                echo "<script>alert('Image file too large.');</script>";
                $success = 0;
            }
            if($success == 1){
                if(move_uploaded_file($_FILES['file']["tmp_name"], "Profile Pictures/".$user.".".$ext)){
                    $query = "UPDATE ".$this->database.".clients SET extension=? where username=?";
                    $run = $this->connect()->prepare($query);
                    $run->execute([$ext, $user]);
                }else{
                    echo "</script>alert('Failed to upload image.');</script>";
                }
            }
        }
    }
}

$myClass = new changeImage();
$myClass->change();
header("Location:profilePage.php");

?>