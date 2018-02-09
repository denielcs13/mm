<?php 
session_start();
require 'include/connect.php';

$userid= mysqli_escape_string($con, $_POST['userid']);
$password=  mysqli_escape_string($con, $_POST['password']);

//echo $email.''.$password;
$query=mysqli_query($con, "SELECT * FROM `admin` WHERE `user_id`='$userid' AND `password`='$password'" );
$result=mysqli_num_rows($query);
if($result>0){
    $_SESSION['userid']=$userid;
    $_SESSION['id']=  session_id();
    $_SESSION['login_type']="admin";
     echo '<script>alert("login successfull");window.location.assign("home.php");</script>'; 
    //echo 'ok';
    
    
}
 else {
    echo '<script>alert("email or password wrong.");window.location.assign("index.php");</script>'; 
}
?>