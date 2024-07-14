<?php
    require "databaseLogIn.php";
    require "token.php";
    class logIn extends connection{
        
        public function authenticate(){
            @$user = $_POST['username'];
            @$pass = $_POST['password'];
            if(isset($user)){
                $query = "select * from ".$this->database.".clients where username =?";
                $executed = $this->connect()->prepare($query);
                $executed->execute([$user]);
                if($executed->rowCount() > 0){
                    while($items = $executed->fetch()){
                        if(password_verify($pass,$items['password'])){
                            session_start();
                            $_SESSION['user'] = $user;
                            header("Location:homePage.php");
                            die;
                        }
                    }
                }
            }
        }
        public function checkUser(){
            @$user = $this->encode($_POST['username']);
            @$pass = $this->encode($_POST['password']);
            if(strlen($user) > 0 && isset($user)){
                $query = "select * from ".$this->database.".clients where username =?";
                $executed = $this->connect()->prepare($query);
                $executed->execute([$user]);
                if($executed->rowCount() < 1){
                    echo "<p class='error' id='uE'>* No such user<p>";
                }
            }
        }
        public function checkPwd(){
            @$user = $this->encode($_POST['username']);
            @$pass = $this->encode($_POST['password']);
            if(isset($user) && strlen($user) > 0){           
                 $query = "select * from ".$this->database.".clients where username =?";
                $executed = $this->connect()->prepare($query);
                $executed->execute([$user]);
                if($executed->rowCount() > 0){
                    while($items = $executed->fetch()){
                        $check_pass = password_verify($pass,$items['password']);
                        if(!$check_pass){
                            echo "<p class='error' id='lE'> *Wrong Password</p>";
                        }
                    }
                }
            }
        }
    }
    $myClass = new logIn();
    $myClass->authenticate();
    $token = Token::generate();
?>
<html id="mainBg">
<head>
<title>Handouts Log in</title>
<?php require_once('links.php');?>
    <script type="text/javascript">
        function check(){
            var user = document .getElementById('username').value;
            var pass = document.getElementById('pass').value;
            var uE = document.getElementById("uE");
            var pE = document.getElementById("lE");
            uE.innerHTML = "";
            pE.innerHTML = "";
            if(user == "" || user == "new"){
                
                uE.innerHTML = "* Enter a valid username";
                return false;
            }
            if(pass == ""){
                
                pE.innerHTML = "* Enter a valid password";
                return false;
            }
        }
    </script>
</head>

<body id="logInBody">
    <center>
        <div id="forgot_div" class="log_hide">
            <form action="recovery.php" method="GET">
                <h1>Account Recovery</h1>
                Enter Username or email<br>
                <input type="email" class="luser" name="forgot" required><br>
                <p id="eE" class="error"></p><br>
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input type="submit" name="forgot_password" value="Get Code" class="padding" id="button"><br><br><br><br><br>
                <p id="back">Back to Login</p>
            </form>
        </div>
        <div class="logIn" id="logIn">
            <h1>Log in</h1>
            <form action="logIn.php" onsubmit="return check()" method="post">
                <p>Username</p><input type="text" name="username" class="luser" id="username"><br>
                <?php
                   $myClass->checkUser();
                ?>
                <p id="uE" class="error"></p>
                <p>Password</p><input type="password" name="password" class="luser" id="pass"><br>
                <?php
                    $myClass->checkPwd();
                ?>
                <p id="lE" class="error"></p>
                <input type="submit" value="Log In" class="padding" id="button"/><br><br>
                <a href="signup.php" class="padding" id="link">Sign up</a><br><br>
                <p id="forgot_password">Forgot password</p>
            </form>
        </div>
    </center>
    <script type="text/javascript">
        
        var forgot_password = document.getElementById("forgot_password");
        var forgot = document.getElementById("forgot_div");
        var login = document.getElementById("logIn");
        var back_login = document.getElementById("back");
        forgot_password.onclick = function (){
            login.className = "log_hide";
            forgot.className = "logIn";
        }
        back_login.onclick = function (){
            forgot.className = "log_hide";
            login.className = "logIn";
        }
    </script>
    
</body>
</html>