<?php 
session_start();

if(!isset($_SESSION['user'])){
    header("location:logIn.php");
}

include("getContent.php") 
?>
<!DOCTYPE html>
<head>
    <?php require_once('links.php');?>
</head>
<html>
<body id="indexBody">
<div id="container">
    <div id="main">
        <div id="indexPage">
        <?php $myClass->set(); ?>
        <div class="full">
        <div class="top">
        <div class="upl">
        <a href="upload.php?state=new" id="ubutton" class="upl">Upload</a></div><br/><br/>
        <h1 id="title">Handouts</h1>
        <img src="top.jpg"><div class="custom"><br/><div id="menu" class="menu_icon menu_active">
            <span class="first_child"></span>
            <span class="middle_child"></span>
            <span class="last_child"></span>
        </div>
        <button id="fil">Filters <span id="span1"></span><span id="span2"></span></button>
        <form action="index.php" id="search" method="get">
        <input type="text" name="search" id="searchItem" placeholder="Search"/>
        <button id = "searchButton">Search</button><br/><br/>
        </form>
        </div>
    <div class="hideFilter" id="filterContent">
        <div id="show">
        <form action="index.php" method="get">
           <table>
                <tr>
                    <td style='text-align:right'><p>Faculty :</p></td>
                    <td><input type="text" name="faculty" id="faculty"></td>
               </tr>
               <tr>
                    <td style='text-align:right'><p>Department :</p></td>
                    <td><input type="text" name="department" id="department"></td>
               </tr>
               <tr>
                    <td style='text-align:right'><p>Unit Code :</p></td>
                    <td><input type="text" id="ucode" name="ucode"></td>
               </tr>
               <tr>
                    <td style='text-align:right'><p>Sort by :</p></td>
                    <td><select name="sort" id='sort'><option value="Date">Date</option><option value="Alphabet">Name</option></select></td>
               </tr>
               <tr>
                    <td style='text-align:right'><p>Year :</p></td>
                    <td><select name="year" id="year"><option value="all" id="yall">All</option><option id="1"value="1">1</option><option id="2"value="2">2</option><option id="3"value="3">3</option><option id="4"value="4">4</option><option id="other" value="other">Other</option></select></td>
               </tr>
               <tr>
                    <td style='text-align:right'><p>Type :</p></td>
                    <td><select name="type" id="type"><option value="all" id="tall">All</option><option value="Exam" id="exam">Exam</option><option value="Handout" id="handout">Handout</option><option value="cat" id="cat">CAT</option>><option value="thesis" id="thesis">Thesis</option><option value="ebook" id="ebook">eBook</option><option value="other" id="othertype">Other</option></select></td>
               </tr>
            </table>
            <div class="bottom">
            <input type="submit" value="Apply" id="done"><br/><br/></div>
        </form>
        <form action="remove.php" method="post" onsubmit="return remove()"><div class="bottom"><input type="submit" value="Remove filters" id="remove"></div></form>
    </div>
    </div>
    </div>
    <p id="info1" class="info"></p>
    <script type=text/javascript>
          var code = "<?=$_SESSION['code'];?>";
            var code2 = "<?=$_SESSION['safe_code'];?>";
          var year = "<?=$_SESSION['year'];?>";
          var type = "<?=$_SESSION['type'];?>";
          var faculty = "<?=$_SESSION['faculty'];?>";
        var faculty2 = "<?=$_SESSION['safe_faculty'];?>";
          var department = "<?=$_SESSION['department'];?>";
         var department2 = "<?=$_SESSION['safe_department'];?>";  
        try{document.getElementById('ucode').value = code;}catch(err){} 
            try{document.getElementById('year').value = year;}catch(err){}
            try{document.getElementById('type').value = type;}catch(err){}
        
        try{document.getElementById('faculty').value = faculty;}catch(err){}
        
        try{document.getElementById('department').value = department;}catch(err){}
                
        if(code =="" && year=="" && type=="" && faculty == "" && department == ""){
          document.getElementById('info1').innerHTML = "Filters: None";  
        }else{
           if(code2 == ""){
           code2 = "All";
       } 
       if(year=="" || year == "all"){
           year = "All";
       } 
       if(type == "" || type == "all"){
           type = "All";
       }
        if(faculty2 == "" || faculty2 == "all"){
            faculty2 = "All";
        }
        if(department2 == "" || department2 == "all"){
            department2 = "All";
        }
    document.getElementById('info1').innerHTML = "Filters: Unit code - "+code2+", Year - "+year+", Type - "+type+", Faculty - "+faculty2+", Department - "+department2;
        }
        </script>
    <p id="info2" class="info"></p>
    <script type=text/javascript>
        try{
            var search = "<?=$_SESSION['search'];?>";
           
           var search2 = "<?=$_SESSION['safe_search'];?>"; document.getElementById('searchItem').value = search;
            var item = document.getElementById('info2');
            if(search != ""){
                item.innerHTML = "Search results for "+search2;
            }
        }catch(err){}
    </script>
    </div>
        <center>
        <div id="right_panel" class="right_panel_full" style="display: block; height: 100%; width: 100%">
            
                <div class="content">
                <?php $myClass->getContent(); ?>
                </div>
            
        </div>
        </center>
        <div id="left_panel" class="left_panel_hidden">
            <?php require_once('menu.php');?>
        </div>
    </div>
    </div>
    <script type="text/javascript" src="menuScript.js"></script>
    <script type="text/javascript" src="mainScript.js"></script>
</div>
    <?php require_once('footer.php');?>
</body>
</html>
<?php
    include_once("paymentModal.php");
?>