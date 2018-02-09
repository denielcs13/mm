<?php 
session_start();
session_destroy();
//header('location:index.php');
echo '<script>alert("logout successfull");window.location.assign("index.php");</script>'; 
?>