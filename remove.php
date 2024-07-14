<?php
session_start();
 if(isset($_SESSION['code'])){
        unset($_SESSION['code']);
    }
if(isset($_SESSION['year'])){
        unset($_SESSION['year']);
    }
if(isset($_SESSION['type'])){
        unset($_SESSION['type']);
    }
if(isset($_SESSION['search'])){
        unset($_SESSION['search']);
    }
if(isset($_SESSION['faculty'])){
        unset($_SESSION['faculty']);
    }
if(isset($_SESSION['department'])){
        unset($_SESSION['department']);
    }
header("Location: index.php");
    
?>