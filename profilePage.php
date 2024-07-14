<?php
session_start();
include "databaseLogIn.php";
include "token.php";
class profile_page extends connection{
    
    
    public function get_user(){
        $user = $this->encode($_SESSION['user']);
        echo"$user";
    }
    
    public function get_pic(){
        $query = "SELECT extension from ".$this->database.".clients where username=?";
        $run=$this->connect()->prepare($query);
        $run->execute([$_SESSION['user']]);
        $ext ="null";
        while($item = $run->fetch()){
            $ext=$item['extension'];
        }
        $path = "Profile Pictures/".$_SESSION['user'].".".$ext;
        if(file_exists($path)){
            echo "<img src='$path' alt='Profile Picture' id='profile_page_image'>";
        }else{
            echo "<img src='profile.jpg' alt='Profile Picture' id='profile_page_image'>";
        }
        
    }
    
    public function get_occupation(){
        $user = $_SESSION['user'];
        $query = "select occupation from ".$this->database.".clients where username=?";
        
        $result = $this->connect()->prepare($query);
         
        $result->execute([$user]);
         while($items = $result->fetch()){
           $occ = $this->encode($items['occupation']);
             echo"$occ";
                    }
    }
    
    public function get_regNo(){
        $user = $_SESSION['user'];
        $query = "select RegNo from ".$this->database.".clients where username=?";
        
        $result = $this->connect()->prepare($query);
         
        $result->execute([$user]);
        
         while($items = $result->fetch()){
            $occ = $this->encode($items['occupation']);
             echo"$occ";
                    }
    }
    
    public function get_email(){
        $user = $_SESSION['user'];
        $query = "select email from ".$this->database.".clients where username=?";
        
        $result = $this->connect()->prepare($query);
         
        $result->execute([$user]);
        
         while($items = $result->fetch()){
            $occ = $this->encode($items['email']);
             echo"$occ";
        }
    }
    
}

$myClass = new profile_page();
$token = Token::generate();
?>

<!DOCTYPE html>
<html id="profile_page">
    <head>
    <?php require_once('links.php');?>
    </head>
    
     <body id="profileBody">
<div id="container">
    <div id="main">
     <div id="profile_page_top">
         <div id="profile_page_menu" class=" profile_page_button menu_icon">
            <span class="first_child"></span>
            <span class="middle_child"></span>
            <span class="last_child"></span>
        </div>
         <p id="profile_page_about">About us</p>
         <center>
       <h1>Welcome</h1>
            </center>
            <img src="top.jpg" class="profile_page_top_image">
             
    </div>
     <div id="profile_page_left_panel" class="hidden">
            <?php require_once('menu.php');?>
        </div>
        <div id="profile_cover" style=" display: block">
        <div id="profile_page_right_panel" class="profile_page_left_panel_full">
    <center>
        <p id="profile_page_heading">Manage your profile</p>
            </center>
        <div id="profile_page_content">
             <div id="profile_page_content_left" class="profile_pop_up">
                        <?php $myClass->get_pic();?>
                        </div>
            <table>
                <tr>
                    <td>
                       
                    </td>
                    <td>
                        <div id="profile_page_content_right">
                    <table style="line-height: 30px;">
                        <tr>
                            <td style="text-align: right"><p>Username&nbsp;: </p></td>
                            <td><p id="profile_page_name"> <?php $myClass->get_user();?></p></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><p>Occupation&nbsp;: </p></td>
                            <td><p id="profile_page_occupation"><?php $myClass->get_occupation();?></p></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><p>Email&nbsp;: </p></td>
                            <td><p id="profile_page_email" ><?php $myClass->get_email();?></p></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><p>Level&nbsp;: </p></td>
                            <td><p id="profile_page_course"><?php echo "Level";?></p></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><p>Reg&nbsp;Number&nbsp;: </p></td>
                            <td> <p id="profile_page_regNo"><?php echo "RegNo";?></p></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><p>Password&nbsp;:</p></td>
                            <td><p id="profile_page_pwd">Change&nbsp;Password</p></td>
                        </tr>
                    </table>
                    </div>
                    </td>
                </tr>
            </table>
        </div>    
        <div id="forms">
            <center>
            <div id="profile_change_image" class="profile_hidden"> 
            <form action="changeImage.php" method="post" enctype="multipart/form-data">
            Select a new image : <input type="file" name='file'>
            <input type="hidden" name='token' value='<?php echo $token;?>'>
            <br><br>
            <input type="submit" name="submit_image" value="Upload" class="profile_page_button">
            </form>
        
        </div>
        <div id="profile_change_pwd" class="profile_hidden">
            <form action="changePwd.php" method="post">
                <table style="line-height: 23px;">
                    <tr>
                        <td style="text-align: right"> Enter old password: </td>
                        <td><input type="password" name="old_pwd" required></td>
                    </tr>
                    <tr>
                        <td style="text-align: right"> Enter new password: </td>
                        <td><input type="password" name="new_pwd" required></td>
                    </tr>
                    <tr>
                        <td style="text-align: right"> Confirm new password: </td>
                        <td><input type="password" name="confirm_pwd" required></td>
                    </tr>
                </table>
                <input type="hidden" name='token' value='<?php echo $token;?>'>
            <input type="submit" name="change_pwd" value="Upload" class="profile_page_button">
            </form>
        </div>
        <div id="profile_change_name" class="profile_hidden">
            <form action="changeName.php" method="post">
            Enter new name : <input type="text" name='name' required>
            <input type="hidden" name='token' value='<?php echo $token;?>'>
            <br><br>
            <input type="submit" name="submit_name" value="Upload" class="profile_page_button">
            </form>
        
        </div>
        <div id="profile_change_occupation" class="profile_hidden">
        
            <form action="changeOccupation.php" method="post">
            Select your occupation : <input type="text" name='occupation'>
            <input type="hidden" name='token' value='<?php echo $token;?>'>
            <br><br>
            <input type="submit" name="submit_occupation" value="Upload" class="profile_page_button">
            </form>
        </div>
        <div id="profile_change_email" class="profile_hidden"> 
            
            <form action="changeEmail.php" method="post">
            Enter new email : <input type="email" name='email' required>
            <input type="hidden" name='token' value='<?php echo $token;?>'>
            <br><br>
            <input type="submit" name="submit_email" value="Upload" class="profile_page_button">
            </form></div>
        <div id="profile_change_regNo" class="hidden"><form action="changeRegNo.php" method="post">
            Enter your registration Number : <input type="text" name='regNo'>
            <input type="hidden" name='token' value='<?php echo $token;?>'>
            <br><br>
            <input type="submit" name="submit_regNo" value="Upload" class="profile_page_button">
            </form></div>
        </center>
        </div>
        
    </div>
    <script type="text/javascript" src="menuScript.js"></script>   
    <script type="text/javascript" src="profilePageScript.js"></script>  
    </div>  
    </div>
</div>
    <?php require_once('footer.php');?>
</body>

</html>