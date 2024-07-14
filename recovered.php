<?php
    include "databaseLogIn.php";
    session_start();
    require "token.php";

    class recovered extends connection{
        public function set(){
            if(!isset($_POST['token']) || !Token::check($_POST['token'])){
                return;
            }
            
            if(isset($_POST['reset_password']) && isset($_SESSION['user'])){
                $pass = $_POST['pass'];
                $confirm = $_POST['confirm'];
               
                if(strlen($pass) >= 6 && $pass === $confirm){
                    $query = "UPDATE ".$this->database.".clients SET password = ? where username= ?";
                    $res = $this->connect()->prepare($query);
                    $res->execute([password_hash($pass, PASSWORD_DEFAULT), $_SESSION['user']]);
                   echo "<script>alert('Password changed successfully');window.open('homePage.php','_self');</script>";
                }
            }
        }
        
        public function report(){
            if(isset($_POST['reset_password'])&& isset($_SESSION['user'])){
               
                $pass = $_POST['pass'];
                $confirm = $_POST['confirm'];
                if(strlen($pass) < 6){
                    echo "<script> var mess = document.getElementById('mess');
                    mess.innerHTML='* Use at least 6 characters';
                    </script>";
                return;
                }
                if($pass !== $confirm){
                    echo "<script> var mess = document.getElementById('mess');
                    mess.innerHTML='* Passwords do not match';
                    </script>";
                }  
            }
            
        }
    }
    $myClass = new recovered();
    $myClass->set();
    $token = Token::generate();
?>
<!DOCTYPE html>
<html id="recovery_body">
<head>
    <title>Account Recovery</title>
    <meta charset="utf-8"/> 
        <link href="styles.css" rel="stylesheet"/>
    </head>
    <body >
        <center>
            <div id="recovery">
                <h1>Account Recovery</h1>
                <form action="recovered.php" method="post">
                    Enter new password<br>
                    <input type="password" name="pass" class="luser" required>
                    <br>
                    Confirm new password<br>
                    <input type="password" name="confirm" class="luser" required>
                    <br>
                    <p class="error" id="mess"></p><br>
                    <?php echo $myClass->report();?>
                    <input type="hidden" name="token" value="<?php echo $token?>">
                    <input type="submit" value="Done" class="padding" id="button" name="reset_password"><br><br><br>
                </form>
            </div>
        
        </center>
    </body>
    
</html>