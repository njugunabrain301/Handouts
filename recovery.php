<?php
    include "databaseLogIn.php";
    require_once "token.php";

    class recovery extends connection {
        public function sendEmail(){
            
            if(isset($_POST['recovery_code'])){
                return;
            }
            if(!isset($_GET['token']) || !Token::check($_GET['token'])){
                echo "<script>window.open('logIn.php','_self');</script>";
            return;
            }
            $identity = $_GET['forgot'];
            $query = "SELECT * from ".$this->database.".clients where username = ? or email = ?";
            $result = $this->connect()->prepare($query);
            $result->execute([$identity, $identity]);
            
            if($result->rowCount() < 1){
                echo "<div class='recovery_modal'>
                    <div id='recovery_content'>
                        <div id='recovery_top'></div>
                        <p>The email provided does not exist.</p><br><br>
                        <a href='logIn.php'>Back</a>
                    </div>
                </div>";
            }else{
                while($item = $result->fetch()){
                    $email = $item['email'];
                    $user = $item['Username'];
                    $code = rand(100000,999999);
                    $query = "UPDATE ".$this->database.".clients SET recovery_code = ? where username= ?";
                    $res = $this->connect()->prepare($query);
                    $res->execute([$code, $user]);
                    if(!mail($email, "Handouts Recovery Code","Your recovery code is ".$code)){
                        echo "<script>alert('Email not sent');
                        window.open('logIn.php','_self');</script>";
                        
                    }else{
                        echo "<script>alert('Email sent');</script>";
                    }
                }
            }
        }
        public function compare(){
            if(isset($_POST['recovery_code'])){
                $identity = $_GET['forgot'];
                $code = $_POST['code'];
            
                $query = "SELECT * from ".$this->database.".clients where username = ? or email = ?";
                $result = $this->connect()->prepare($query);
                $result->execute([$identity, $identity]);
                
                while($item = $result->fetch()){
                    $mCode = $item['recovery_code'];
                    
                    if($code == $mCode){
                        @session_start();
                        $_SESSION['user'] = $item['Username'];
                        $user = $_SESSION['user'];
                        echo "<script>window.open('recovered.php','_self');</script>";
                    }
                }
            }
        }
        
        public function report(){
            if(isset($_POST['recovery_code'])){
                $identity = $_GET['forgot'];
                $code = $_POST['code'];
            
                $query = "SELECT * from ".$this->database.".clients where username = ? or email = ?";
                $result = $this->connect()->prepare($query);
                $result->execute([$identity, $identity]);
            
                while($item = $result->fetch()){
                    if($code === $item['recovery_code']){
                    }else{
                        echo "<script> var mess = document.getElementById('mess');
                    mess.innerHTML='* The code does not match';
                    </script>";  
                    }
                }
                
            }
        }
        
        public function getForgot(){
            return $this->encode($_GET['forgot']);
        }
    }

    $myClass = new recovery();
    
?>
<!DOCTYPE html>
<html id="recovery_body" style="overflow-y:hidden">
<head>
    <title>Account Recovery</title>
    <?php require_once('links.php');
    $myClass->sendEmail();
    $myClass->compare();
    $token = Token::generate();
    ?>
    </head>
    <body >
        <center>
            <div id="recovery">
                <h1>Account Recovery</h1>
                <form action="recovery.php?forgot=<?php echo $myClass->getForgot();?>" method="post">
                    Enter recovery code<br>
                    <input type="text" name="code" class="luser" required id="code">
                    <br>
                    <p class="error" id="mess"></p><br>
                    <?php $myClass->report();?>
                    <input type="hidden" name="token" value = "<?php echo $token;?>">
                    <input type="submit" value="Submit" class="padding" id="button" name="recovery_code"><br><br><br>
                    <p id="back">Back to login</p>
                </form>
            </div>
        
        </center>
        <script>
            var back = document.getElementById("back");
            back.onclick = function () {
                window.open("logIn.php","_self");
            }
        </script>
    </body>
    
</html>