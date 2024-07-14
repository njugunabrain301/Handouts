<?php
include 'databaseLogIn.php';
session_start();

class home extends connection {
    
    public function get_pic(){
        $query = "SELECT extension from handouts.clients where username=?";
        $run=$this->connect()->prepare($query);
        $run->execute([$_SESSION['user']]);
        $ext ="null";
        while($item = $run->fetch()){
            $ext=$item['extension'];
        }
        $path = "Profile Pictures/".$_SESSION['user'].".".$ext;
        if(file_exists($path)){
            echo "<img src='$path' alt='Profile Picture' id='home_page_top_profile_img'>";
        }else{
            echo "<img src='profile.jpg' alt='Profile Picture' id='home_page_top_profile_img'>";
        }
    }
}
$myClass = new home();
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once('links.php');?>
</head>
    <body id="indexBody">
<div id="home_page" class="home_body">
    <div id="main">
        <div id="home_page_top">
            <?php $myClass->get_pic();?>
            <center>
            <h1 id="h1">Welcome</h1>
            <img src="top.jpg" class="home_page_top_image">
             </center>
            <?php
                if(isset($_SESSION['user'])){
                    echo "<div class='home_page_logIn'>Logged in as ".htmlspecialchars($_SESSION['user'])."</div>";
                }
            ?>
            <p id="home_page_top_about" class='home_page_logIn'>About us</p>
           
        </div>
            <center>
            <p id="home_page_title"></p>
        </center>
        <center class="home_page_center">
            
        <div class="home_page_content" id="handouts"> <br>Handouts<br><br><p class="home_page_info_text"> Get all the handouts you need in one place </p></div>
        <div class="home_page_content" id="exam"><br>Exam Papers<br><br><p class="home_page_info_text">All previous exam papers made available for reference</p></div>
        <div class="home_page_content" id="cat"><br>Cat Papers<br><br><p class="home_page_info_text">Go through all our available cat papers to gain the knowledge you need</p></div>
        <div class="home_page_content" id="ebook"><br>eBooks<br><br><p class="home_page_info_text">Explore our vast collection of online books from all the various subjects</p></div>
        <div class="home_page_content" id="thesis"> <br>Thesis<br><br><p class="home_page_info_text">Study past researches, dissertations and theses to get credible content for your reports</p></div>
        <div class="home_page_content" id="upload"><br>Upload<br><br><p class="home_page_info_text">Help us grow our information source by uploading new credible content</p></div>
        <div class="home_page_content" id="profile"><br> Profile<br><br><p class="home_page_info_text">Add and update your account information</p></div>
        <div class="home_page_content" id="logOut"><br>Log Out<br><br><p class="home_page_info_text">We hope you had a wonderful experience. To give us feedback contact us by the email provided below</p></div>
        </center>
        <script src="homePageScript.js" type="text/javascript"></script>
    </div>  
</div>
<?php require_once('footer.php');?>
</body>

</html>