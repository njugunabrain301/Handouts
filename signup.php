<?php
    require "databaseLogIn.php";
    include "token.php";

    class signUp extends connection{
        private $isGood = 0;
        public function sign_up(){
            @$user = $_POST['username'];
            @$pass = $_POST['password'];
            @$occupation = $_POST['occupation'];
            @$email = $_POST['email'];
            @$regNo= $_POST['regNo'];
            $fileUploaded = 0;
            if(!isset($pass)){
                return;
            }
            if(!isset($_POST['token']) || !Token::check($_POST['token'])){
                return;
            }
            if(isset($user)){
                $query = "select * from ".$this->database.".clients where username =?";
                $result1 = $this->connect()->prepare($query);
                $result1->execute([$user]);
                
                $query = "select * from ".$this->database.".clients where email =?";
                $result2 = $this->connect()->prepare($query);
                $result2->execute([$email]);
                
                if($result1->rowCount() > 0 || $result2->rowCount() > 0){
                }else{
                    $hass = password_hash($pass, PASSWORD_DEFAULT);
                    
                    
                    $query = "INSERT INTO ".$this->database.".clients(username, occupation, password, email) VALUES(?,?,?,?)";
                    $result = $this->connect()->prepare($query);
                    $result->execute([$user, $occupation, $hass, $email]);
                    
                    if(isset($regNo)){
                        $query = "UPDATE ".$this->database.".clients SET RegNo = ? WHERE username = ?";
                        $result = $this->connect()->prepare($query);
                        $result->execute([$regNo, $user]);
                    }
                    
                    
                    $success = 1;             
                    $this->isGood = 1;
                    $target_dir = "Profile Pictures/";
                    $target_file = $target_dir.basename($_FILES['file']["name"]);
                    
                    $ext = strtolower(end(explode('.',$target_file)));
                    $info = "<p>You can add a different picture through the profile tab once you log in.</p>";
                    $exts = array("jpg", "jpeg","gif","png");
                    if($target_file === $target_dir){
                        $fileUploaded = 0;
                        $success = 0;
                    }else{
                       $fileUploaded = 1; if(!in_array($ext,$exts)){
                            echo "<div class='recovery_modal'>
                    <div id='recovery_content'>
                        <div id='recovery_top'></div>
                        <p>File type not supported.</p>$info<br><br>
                        <a href='#' id= 'proceed' >Proceed</a>
                    </div>
                </div>";
                            $success = 0;
                        }else if($_FILES['file']['size'] > 10485760){
                             echo "<div class='recovery_modal'>
                    <div id='recovery_content'>
                        <div id='recovery_top'></div>
                        <p>File image too large.</p>$info<br><br>
                        <a href='#' id= 'proceed' >Proceed</a>
                    </div>
                </div>";
                            $success = 0;
                        }
                        
                        if($success === 1){
                            if(move_uploaded_file($_FILES['file']["tmp_name"], "Profile Pictures/".$user.".".$ext)){
                                $query = "UPDATE  ".$this->database.".clients SET extension=? where username=?";
                                $run=$this->connect()->prepare($query);
                                $run->execute([$ext, $user]);
                            }else{
                                 echo "<div class='recovery_modal'>
                    <div id='recovery_content'>
                        <div id='recovery_top'></div>
                        <p>Failed to upload image.</p>$info<br><br>
                        <a href='#' id= 'proceed' >Proceed</a>
                    </div>
                </div>";
                            }
                        }
                    }
                    @session_start();
                    $_SESSION['user'] = $user;
                    $_SESSION['regNo']= $regNo;
                    
                    if($this->isGood === 1 && $fileUploaded === 0){
                        echo "<script>window.open('homePage.php','_self')</script>";    
                    }
                    
                }
            }
        }
        
        public function report(){
           @$user = $_POST['username'];
            if($this->isGood === 1){
                return;
            }
                    if(isset($user)){
                                $query = "select * from ".$this->database.".clients where username = ?";
                        $results = $this->connect()->prepare($query);
                        $results->execute([$user]);
                        if($results->rowCount() > 0){
                            echo "<p id='un' class='serror'>* Username already exists </p>";
                        }
                    } 
        }
        public function report2(){
             @$email = $_POST['email'];
             if($this->isGood === 1){
                return;
            }
            if(isset($email)){
                $query = "select * from ".$this->database.".clients where email = ?";
                $results = $this->connect()->prepare($query);
                $results->execute([$email]);
                if($results->rowCount() > 0){
                    echo "<p id='en' class='serror'>* Email already exists </p>";
                }
            } 
        }
    }
    
     $myClass = new signUp();

    $myClass->sign_up();
    $token = Token::generate();
?>
<!DOCTYPE html>
<html id="mainBg">
<head>
<title>Handouts Sign up</title>
<?php require_once('links.php');?>
    <script type="text/javascript">
        function showFileSize() {
        var input, file;

        // (Can't use `typeof FileReader === "function"` because apparently
        // it comes back as "object" on some browsers. So just see if it's there
        // at all.)
        if (!window.FileReader) {
        return;
        }

        input = document.getElementById('file');
        if (!input) {
        }
        else if (!input.files) {
        }
        else if (!input.files[0]) {
        }
        else {
            for (var i = 0; i <         input.files.length; ++i) {
                file = input.files[i];
                size = file.size/1048576;
                if(size <= 10){
                    return true;
                }else{
                    return false;
                }
            }
            
        }
        return true;
    }
        function check2(){
            try{
              var us = document.getElementById('un');
                us.className = "Rn";  
            }catch(err){
            }
            var pe = document.getElementById('pE');
            pe.innerHTML = "";
            try{
                var un = document.getElementById('un');
                un.innerHTML = "";
            }catch(err){}
            try{
                var en = document.getElementById('en');
                en.innerHTML = "";
            }catch(err){}
            var pass = document.getElementById('pass').value;
            var confirm = document.getElementById('confirm').value;
            var user = document.getElementById('user').value;
            var occupation = document.getElementById('Occupation').value;
            var email = document.getElementById('email').value;
            var regNo = document.getElementById('regNo').value;
            var mE = document.getElementById('mE');
            mE.innerHTML = "";
            if(email == "" || user == "" || occupation == "" || pass == "" || confirm == ""){
                mE.innerHTML = " * Fill in all fields";
                return false;
            }else if( occupation.toUpperCase() == "STUDENT" && regNo == ""){
                 mE.innerHTML = "&nbsp;*&nbsp;Students&nbsp;must&nbsp;fill&nbsp;in&nbsp;'Reg Number'&nbsp;field";  
                return false;
            }else if(pass.length < 6){
                pe.innerHTML="*&nbsp;Use&nbsp;atleast&nbsp;6&nbsp;characters";
                return false;
            }else if(!showFileSize()){
                mE.innerHTML = "* Image file should be less than 10Mb"; 
                return false;
            }else if(pass === confirm){
                    return true;   
            }else{
                pe.innerHTML="*&nbsp;Passwords&nbsp;do&nbsp;not&nbsp;match";
                return false;  
            }
            
        }
        function check(){
            
            var occupation = document.getElementById("Occupation").value;
            var regNo = document.getElementById("Rn");
            if(occupation.toUpperCase()=="STUDENT"){
                regNo.className = "";
            }else{
                regNo.className = "Rn";
            }
        }
        
    </script>
</head>
<body id="signUpBody">
    <center>
        
        <div class="signup">
            <h1>Sign up</h1>
            <form action="signup.php" method="post"onclick="check()" onsubmit="return check2()" enctype="multipart/form-data">
               <table>
                    <tr>
                        <td style="text-align: right"><p>Username :</p></td>
                        <td><input type="text" name="username" class="signup_content" id="user"><br>
                        <?php
                            $myClass->report();
                        ?>
                        </td>
                   </tr>
                   <tr><td style="align-text: center;"></td></tr>
                    <tr>
                        <td style="text-align: right"><p>Occupation :</p></td>
                        <td><input type="text" name="occupation" class="signup_content" placeholder="ie student, lecturer" id="Occupation"></td>
                   </tr>
                   
                   <div class="Rn" id="Rn">
                   <tr>
                        <td style="text-align: right"><p>Reg Number :</p></td>
                        <td><input type="text" name="regNo" class="signup_content" id="regNo" placeholder="(Optional for non-students)"></td>
                   </tr>
                    </div>
                   <tr>
                        <td style="text-align: right"><p>Password :</p></td>
                        <td><input type="password" name="password" class="signup_content" id="pass"></td>
                   </tr>
                   <tr>
                        <td style="text-align: right; position: relative;" ><p>Confirm&nbsp;Password&nbsp;:</p></td>
                        <td><input type="password" class="signup_content" id="confirm"><br><p id="pE" class="error"></p></td>
                   </tr>
                   <tr>
                        <td style="text-align: right"><p>Email Address :</p></td>
                        <td><input type="email" name="email" class="signup_content" id="email">
                        <?php
                            $myClass->report2();
                        ?>
                       </td>
                   </tr>
                   <tr>
                        <td style="text-align: right"><p>Profile Image</p></td>
                        <td><input type="file" class="signup_content" name="file" id="file" placeholder="(Optional)"></td>
                   </tr>
                </table> 
                <p id="mE" class="serror"></p>
               <br> 
                <input type="hidden" name='token' value='<?php echo $token;?>'>
                <input type="submit" value="Sign up" class="padding" id="button"/><br><br>
                <a href="logIn.php">Back to log in</a>
            </form>
        
        </div>
    
    </center>
    <script type="text/javascript">
        try{
            proceed = document.getElementById('proceed');
            proceed.onclick = function(){
                window.open("homePage.php","_self");
            }
        }catch(err){}
    </script>
</body>
</html>