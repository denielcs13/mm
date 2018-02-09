<?php 
session_start();
require 'include/connect.php';

$email= mysqli_escape_string($con, $_POST['email']);
$password=  mysqli_escape_string($con, $_POST['password']);

//echo $email.''.$password;
$query=mysqli_query($con, "select * from user where email='$email' and password='$password'" );
$result=mysqli_num_rows($query);
if($result>0){
    $_SESSION['userid']=$email;
    $_SESSION['id']=  session_id();
    $_SESSION['login_type']="user";
     echo '<script>alert("login successfull");window.location.assign("home.php");</script>'; 
    //echo 'ok';
    
    
}
 else {
    echo '<script>alert("email or password wrong.");window.location.assign("index.php");</script>'; 
}
?>