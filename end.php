<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['regNo']);
header("Location:index.php");
?>