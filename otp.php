<?php
session_start();
//$pet = $_SESSION["pet_name"];
//$rno = $_SESSION["otp"];
//$pet_name=$_SESSION['pet_name'];
//$typepet=$_SESSION['typepet'];
//$date_of_birth=$_SESSION['dob'];
//$month=$_SESSION['month'];
//$year=$_SESSION['year'];
//$owner_name=$_SESSION['owner_name'];
$email=$_SESSION['email'];
print_r($_SESSION);
//$passwords=$_SESSION['password'];
//$country=$_SESSION['country'];
//$mobile=$_SESSION['mobile'];
//$rannum=rand(11111,99999);
//$ran=$rannum;
//$_SESSION['otp']=$random_number;
include 'include/connect.php';
if (isset($_POST['submit'])) {
    $otp_verify = $_POST["otp"];
    $result = "SELECT `otp`,`createdOn` FROM `otp` WHERE `otp`='$otp_verify'";
    $query = mysqli_query($con, $result);
    if (mysqli_num_rows($query) == 1) {
        
//        $qu="insert into tbl_petdetails_registration(`id`,`pet_name`,`type_of_pet`,`dob`,`powner_name`,`email`,`password`,`country`,`phone`,`otp`,`pet_unique_id`)values('null','$pet_name','$typepet','$date_of_birth','$owner_name','$owner_email','$passwords','$country','$mobile','$rno',1)";
//    $sqll=mysqli_query($conn,$qu);
//    mkdir("$ran"."/Photos",0777,true);
//    mkdir("$ran"."/Videos",0777,true);
//    mkdir("$ran"."/Shared_Videos",0777,true);
     //echo '<script>alert("Corect otp");</script>';
     $query = mysqli_query($con, "UPDATE `user` SET `status`='active' WHERE `email`='$email'");
     echo '<script>alert("Corect otp");window.location.assign("index.php");</script>';
    }
    else 
    {
        echo "Wrong otp";
        die;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">OTP Verification</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="" >
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Verify Otp" name="otp" type="text" autofocus>
                                </div>                                
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" name="submit" class="btn btn-lg btn-success btn-block">Verify</button>
<!--                                <a href="index.html" class="btn btn-lg btn-success btn-block">Login</a>-->
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>
