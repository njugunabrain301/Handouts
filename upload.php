<?php
    session_start();
    require "databaseLogIn.php";
    if(!isset($_SESSION['user'])){
        header("Location: logIn.php");
        die;
    }
    include "token.php";
class upload extends connection{
    public function upload_file(){
        
        if(!isset($_POST['token']) || !Token::check($_POST['token'])){
            return;
        }
      if(isset($_SESSION['user']) && isset($_POST['submit'])){
        $errors = array();
        $success = 0;
        $try = 0;
        $bad = array();
        $saved = array();
        $exist = array();
        $format= array();
        $large = array();
        if(isset($_POST['submit'])){
            for($i = 0;$i<count($_FILES['file']['name']) ;$i++){
                if($_FILES['file']['size'][$i]>26214400){
                    $bad[count($bad)]=$_FILES['file']['name'][$i];
                }
            }
        }
        if(@isset($_POST['submit']) && count($bad)==0){
            $title = $this->encode($_POST['title']);
            $code = $this->encode($_POST['ucode']);
            $type = $this->encode($_POST['type']);
            $year = $this->encode($_POST['year']);
            $faculty = $this->encode($_POST['faculty']);
            $department = $this->encode($_POST['department']);
            $try = 1;
            for($i = 0;$i<count($_FILES['file']['name']) ;$i++){
            $success = 1;
            $target_dir = "documents/";
            $target_file = $this->encode($target_dir.basename($_FILES['file']["name"][$i]));
            $ext = $this->encode(strtolower(end(explode('.',$_FILES['file']['name'][$i]))));
            $exts = array("doc", "docx","html","htm","odt","pdf","xls","xlsx","ods","ppt","pptx","txt");
            if($target_file == $target_dir){
                $success = 0;
                echo "<p class='perror' id='pl'> * Select a file to submit</p><br>"; 
            }else{
            if(!in_array($ext,$exts)){
               $success = 0;
                $format[count($format)] = $_FILES['file']['name'][$i];
            }
            if(file_exists($target_file)){
               $success = 0; $exist[count($exist)]=$_FILES['file']['name'][$i];
            }
            if($_FILES['file']['size'][$i] > 52428800){
               $success = 0;
                $large[count($large)]=$_FILES['file']['name'][$i];;
           }
         if($success == 1){
         if(move_uploaded_file($_FILES['file']["tmp_name"][$i], $target_file)){
                $query = "insert into ".$this->database.".handouts(name, unitTitle, date, type, uploader, unitCode, year, faculty, department) values(?,?,?,?,?,?,?,?,?)";
                $run= $this->connect()->prepare($query);
                $run->execute([$_FILES['file']['name'][$i], $title,date("Y/m/d"),$type,$_SESSION['user'],$code,$year,$faculty,$department]);
                $success = 1;
                $saved[count($saved)] = $_FILES['file']['name'][$i];
            }else{
                echo "<p class='pfail' id='pf'><b> Upload Failed</b></p><br>";
                $success = 0;
            }
            }
            }
            }
            
        }
        if(count($saved) >0){
            if(count($saved)>1){
            echo "<p class='psuccess' id='ps'><b>".count($saved)." files Uploaded Successfully</b></br>";
                }else {
            echo "<p class='psuccess' id='ps'><b>".count($saved)." file Uploaded Successfully</p><div id='psname'>".$this->encode($saved[0])."</div><br>";
                }
        }else{
            if(isset($_POST['submit'])){
            echo "<p id='pz'>No file was uploaded</p>";
            }
        }
        if(count($large)>0){
            if(count($large)>1){
                echo "<p class='' id='pz'> * ".count($large)."  files are too large</p>" ;
                }else {
                    echo "<p class='' id='pz'> * ".$this->encode($large[0])."  is too large</p>" ;
                }
        }
        if(count($exist)>0){
            if(count($exist)>1){
                echo "<p class='' id='pz'> * ".count($exist)."  files already exist</p>" ;
                }else {
                    echo "<p class='' id='pz'> * ".$this->encode($exist[0])."  already exists</p>" ;
                }
        }
        if(count($format)>0){
            if(count($format)>1){
                echo "<p class='' id='pz'> * ".count($format)." files are not in the right format</p>" ;
                }else {
                    echo "<p class='' id='pz'> * ".$this->encode($format[0])." is not in the right format</p>" ;
                }
        }
         if(count($bad)>0){
                if(count($bad)>1){
                echo "<p class='' id='pz'> * ".count($bad)." files are too large</p>" ;
                }else {
                    echo "<p class='' id='pz'> * ".$this->encode($bad[0])." file is too large</p>" ;
                }
            }
        if($success == 0 && !@isset($_GET['state'])){
           
            if($try == 0){
               echo "<p class='' id='pz'> * Files should be less than 25Mb</p><br>" ;
            }
            
        }
    }  
    }
}

$myClass = new upload();
$token = Token::generate();
?>
<!DOCTYPE html>
<html id="mainBg">
<head>
<title>Handouts Upload file</title>
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
                if(size <= 50){
                    return true;
                }else{
                    return false;
                }
            }
            
        }
        return false;
    }

    function check(){
        try{
        document.getElementById('pt').innerHTML = "";
        }catch(err){}
        try{
        document.getElementById('pl').innerHTML = "";
        }catch(err){}
        try{
        document.getElementById('zp').innerHTML = "";
        }catch(err){}
        try{
        document.getElementById('pz').innerHTML = "";
        }catch(err){}
        try{
        document.getElementById('ps').innerHTML = "";
        }catch(err){}
        try{ document.getElementById('pf').innerHTML = "";
        }catch(err){}
        try{
        document.getElementById('pr').innerHTML = "";
        }catch(err){}
        try{
        document.getElementById('psname').innerHTML = "";
        }catch(err){}
        try{
        document.getElementById('fp').innerHTML = "";
        }catch(err){}
        var title = document.getElementById('titl').value;
        var code = document.getElementById('pcode').value;
        var file = document.getElementById('file').value;
        var er = document.getElementById('er');
        er.innerHTML = "Uploading...";
        
        var checkSize = showFileSize();
        
        if(title=="" || code == "" || file == ""){
            er.innerHTML = " * Fill in all fields";
            return false;
        }else if(!checkSize){
            er.innerHTML = " * File should be less than 50Mb";
            return false;
        }else{
            return true;
        }
    }
    </script>
</head>
<body id="uploadBody">
<center>
    
<div class="upload">
    <h1>Upload Files</h1>
<form action="upload.php" method="post" enctype="multipart/form-data" onsubmit="return check()">
   <table>
        <tr>
            <td style="text-align: right"><p>Unit Title :</p></td>
            <td><input type="text" class="upload_content" name="title" id="titl"></td>
        </tr>
       <tr>
            <td style="text-align: right"><p>Unit Code :</p></td>
            <td><input type="text" class="upload_content" id="pcode" name="ucode"></td>
        </tr>
       <tr>
            <td style="text-align: right"><p>Year :</p></td>
            <td><select name="year" id="uyear" class="upload_content"><option id="1"value="1">1</option><option id="2"value="2">2</option><option id="3"value="3">3</option><option id="4"value="4">4</option><option id="other" value="other">Other</option></select></td>
        </tr>
       <tr>
            <td style="text-align: right"><p>Type :</p></td>
            <td><select name="type" id="utype" class="upload_content"><option value="Exam" id="exam">Exam</option><option value="Handout" id="handout">Handout</option><option value="cat" id="cat">CAT</option><option value="thesis" id="thesis">Thesis</option><option value="ebook" id="ebook">eBook</option><option value="other" id="othertype">Other</option></select></td>
        </tr>
       <tr>
            <td style="text-align: right"><p>Faculty :</p></td>
            <td><input type='text' name="faculty" id="upload_faculty" class="upload_content"></td>
        </tr>
       <tr>
            <td style="text-align: right"><p>Department :</p></td>
            <td><input type='text' name="department" id="upload_department" class="upload_content"></td>
        </tr>
       <tr>
            <td style="text-align: right"><p>Select File :</p></td>
            <td><input type="file" class="upload_content" name="file[]" id="file" multiple></td>
        </tr>
    </table> 
    <input type="hidden" name='token' value='<?php echo $token;?>'>
    <input type="submit" value="Upload" name="submit" class="padding" id="button"/><br>
    <p class="perror" id="er"></p><br>
    <?php $myClass->upload_file(); ?>
</form>
    <div class="ubottom">
<form action="index.php">
<a href="index.php"><button class="padding" id="button">Back to home page</button></a></form></div>
</div>
</center>
</body>
</html>