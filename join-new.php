<?php
include 'include/check-login.php';
include 'include/connect.php';
$userid = $_SESSION['userid'];
$capping = 500;
?>
<?php
//User cliced on join
if (isset($_GET['join_user'])) {
    $side = '';
    $pin = mysqli_real_escape_string($con, $_GET['pin']);
    $email = mysqli_real_escape_string($con, $_GET['email']);
    $mobile = mysqli_real_escape_string($con, $_GET['mobile']);
    $address = mysqli_real_escape_string($con, $_GET['address']);
    $account = mysqli_real_escape_string($con, $_GET['account']);
    $under_userid = mysqli_real_escape_string($con, $_GET['under_userid']);
    $side = mysqli_real_escape_string($con, $_GET['side']);
    $password = "123456";

    $flag = 0;

    if ($pin != '' && $email != '' && $mobile != '' && $address != '' && $account != '' && $under_userid != '' && $side != '') {
        //User filled all the fields.
        if (pin_check($pin)) {
            //Pin is ok
            if (email_check($email)) {
                //Email is ok
                if (!email_check($under_userid)) {
                    //Under userid is ok
                    if (side_check($under_userid, $side)) {
                        //Side check
                        $flag = 1;
                    } else {
                        echo '<script>alert("The side you selected is not available.");</script>';
                    }
                } else {
                    //check under userid
                    echo '<script>alert("Invalid Under userid.");</script>';
                }
            } else {
                //check email
                echo '<script>alert("This user id already availble.");</script>';
            }
        } else {
            //check pin
            echo '<script>alert("Invalid pin");</script>';
        }
    } else {
        //check all fields are fill
        echo '<script>alert("Please fill all the fields.");</script>';
    }

    //Now we are heree
    //It means all the information is correct
    //Now we will save all the information
    if ($flag == 1) {

        //Insert into User profile
        $query = mysqli_query($con, "INSERT INTO `user`(`email`, `password`, `mobile`, `address`, `account`,`under_userid`,`side`,`date`) VALUES ('$email','$password','$mobile','$address','$account','$under_userid','$side',NOW())");

        //Insert into Tree
        //So that later on we can view tree.
        $query = mysqli_query($con, "INSERT INTO `tree`(`user_id`) VALUES ('$email')");

        //Insert to side
        $query = mysqli_query($con, "UPDATE `tree` SET `$side`='$email' where `user_id`='$under_userid'");

        //Update pin status to close
        $query = mysqli_query($con, "UPDATE `pin_list` SET `status`='close' WHERE `pin`='$pin'");

        //Inset into Icome
        $query = mysqli_query($con, "INSERT INTO `income`(`user_id`) VALUES ('$email')");
        echo mysqli_error($con);
        //This is the main part to join a user\
        //If you will do any mistake here. Then the site will not work.
        //Update count and Income.
        $temp_under_userid = $under_userid;
        $temp_side_count = $side . 'count'; //leftcount or rightcount

        $temp_side = $side;
        $total_count = 1;
        $i = 1;
        while ($total_count > 0) {
            $i;
            $q = mysqli_query($con, "SELECT * FROM `tree` WHERE `user_id`='$temp_under_userid'");
            $r = mysqli_fetch_array($q);
            $current_temp_side_count = $r[$temp_side_count] + 1;
            $temp_under_userid;
            $temp_side_count;
            mysqli_query($con, "UPDATE `tree` SET `$temp_side_count`=$current_temp_side_count WHERE `user_id`='$temp_under_userid'");

            //income
            if ($temp_under_userid != "") {
                $income_data = income($temp_under_userid);
                //check capping
                //$income_data['day_bal'];
                if ($income_data['day_bal'] < $capping) {
                    $tree_data = tree($temp_under_userid);

                    //check leftplusright
                    //$tree_data['leftcount'];
                    //$tree_data['rightcount'];
                    //$leftplusright;

                    $temp_left_count = $tree_data['leftcount'];
                    $temp_right_count = $tree_data['rightcount'];
                    //Both left and right side should at least 1 user
                    if ($temp_left_count > 0 && $temp_right_count > 0) {
                        if ($temp_side == 'left') {
                            $temp_left_count;
                            $temp_right_count;
                            if ($temp_left_count <= $temp_right_count) {

                                $new_day_bal = $income_data['day_bal'] + 100;
                                $new_current_bal = $income_data['current_bal'] + 100;
                                $new_total_bal = $income_data['total_bal'] + 100;

                                //update income
                                mysqli_query($con, "update income set day_bal='$new_day_bal', current_bal='$new_current_bal', total_bal='$new_total_bal' where user_id='$temp_under_userid' limit 1");
                            }
                        } else {
                            if ($temp_right_count <= $temp_left_count) {

                                $new_day_bal = $income_data['day_bal'] + 100;
                                $new_current_bal = $income_data['current_bal'] + 100;
                                $new_total_bal = $income_data['total_bal'] + 100;
                                $temp_under_userid;
                                //update income
                                if (mysqli_query($con, "update income set day_bal='$new_day_bal', current_bal='$new_current_bal', total_bal='$new_total_bal' where user_id='$temp_under_userid'")) {
                                    
                                }
                            }
                        }
                    }//Both left and right side should at least 1 user
                }
                //change under_userid
                $next_under_userid = getUnderId($temp_under_userid);
                $temp_side = getUnderIdPlace($temp_under_userid);
                $temp_side_count = $temp_side . 'count';
                $temp_under_userid = $next_under_userid;

                $i++;
            }

            //Chaeck for the last user
            if ($temp_under_userid == "") {
                $total_count = 0;
            }
        }//Loop

                $random_number = rand(1000000, 9999999);
                //$expireAfter = 2;
                $_SESSION['otp'] = $random_number;
                $_SESSION['email']=$email;
                //$email = $_POST["email"];
                $subject = "MLM verification registration";
                $message = "<body style='width:100%;background-color:#b5b5b5;margin:0;padding:0;'>
<div style='width: 680px;margin:0 auto;font-family:arial;box-sizing: border-box;'>
<div style='width:100%;background-color:#fff;padding: 15px;box-sizing: border-box;border: 20px solid #b5b5b5;box-sizing: border-box;'>
<div style='display:inline-block;width:100%;box-sizing:border-box;border-bottom:1px solid #ccccce;margin-bottom: 12px;'>
<div style='float:left;'><img src='http://petbooq.com/images/logo.jpg'/></div>
<div style='float:right;'>
<a href='http://www.petbooq.com' style='display:inline-block;margin-top:15px;text-decoration:none;color:#000;font-size:13px;text-transform:uppercase;font-weight:bold;'>petbooq.com</a>
</div>
</div>
<div style='display:inline-block;width:100%;text-align:center;'>
<div style='float:left;width:100%;'><img src='http://petbooq.com/images/mailer-banner.jpg' style=''/></div>
</div>
<div style='width:100%;display:inline-block;'>
<div style='display:inline-block;padding: 0px;width:100%;background:#fff;margin-bottom:0px;box-sizing: border-box;'>
<div style='display:inline-block;width:100%;box-sizing:border-box;padding: 0 150px'>
<div style='display:inline-block;width:100%;font-size: 17px;color: #000;line-height: 23px;font-weight:bold;margin-top:10px;'>
You recently registered for Petbooq.
</div>
<p style='display:inline-block;width:100%;font-size: 12px;color:#6e6f73;line-height: 18px;margin: 10px 0 35px;'>
To complete your petbooq registration enter your OTP.
</p>
<p style='display:inline-block;width:100%;font-size: 14px;color:#6e6f73;line-height:25px;margin: 0px 0 15px;'>
<div style='color: rgb(110,111,115);'>Thanks</div>
<div style='color: rgb(110,111,115);'>The Petbooq Team.</div>
</p>
<div style='display:inline-block;width:100%;'>
<div style='display:inline-block;width:100%;padding:5px 0;background-color:#6d6e72;color:#fff;text-transform:uppercase;font-size:23px;text-decoration:none;text-align:center;font-weight:bold;'>".$_SESSION['otp']."</div>
</div>
</div>
</div>
</div>
<div style='display:inline-block;width:100%;border-top:1px solid #ccc;padding-top:15px;margin-top:15px;'>
<div style='float:left;'>
<a href='http://www.petbooq.com' style='display:inline-block;font-size:12px;text-decoration:none;color:#000;'>petbooq.com</a>
<span style='display:inline-block;margin: 0 5px;font-size:12px;color:#000;'>|</span>
<a href='mailto:pets@petbooq.com' style='display:inline-block;font-size:12px;text-decoration:none;color:#000;'>pets@petbooq.com  </a>
</div>
<div style='float:right;'>
<ul style='display:inline-block;padding: 0px;width:100%;margin:0;'>
<li style='display:inline-block;margin: 0;padding: 0;'><a href='https://www.facebook.com/petbooq'><img src='http://petbooq.com/images/social-icon1.png' style=''/></a></li>
<li style='display:inline-block;margin: 0;padding: 0;'><a href='https://www.instagram.com/petbooq/'><img src='http://petbooq.com/images/social-icon2.png' style=''/></a></li>
<li style='display:inline-block;margin: 0;padding: 0;'><a href='https://twitter.com/petbooq'><img src='http://petbooq.com/images/social-icon3.png' style=''/></a></li>
<li style='display:inline-block;margin: 0;padding: 0;'><a href='https://in.pinterest.com/petbooq/'><img src='http://petbooq.com/images/social-icon4.png' style=''/></a></li>
<li style='display:inline-block;margin: 0;padding: 0;'><a href='https://plus.google.com/u/1/113913416342083840664'><img src='http://petbooq.com/images/social-icon5.png' style=''/></a></li>
<li style='display:inline-block;margin: 0;padding: 0;'><a href='https://www.tumblr.com/blog/petbooq1'><img src='http://petbooq.com/images/social-icon6.png' style=''/></a></li>
</ul>
</div>
</div>
</div>
</div>
</body>
";
                    $header = "<h2>MLM Account Verification</h2>";
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: Petbooq<Petbooq@gmail.com>' . "\r\n";
                    mail($email, $subject, $message, $headers);
        //echo mysqli_error($con);
        $query = mysqli_query($con, "INSERT INTO `otp`(`otp`, `email`,`createdOn`) VALUES ('$random_number','$email',NOW())");
        

        // echo '<script>alert("Testing success.");</script>';
        echo '<script>alert("Registration successfull");window.location.assign("otp.php");</script>'; 
    }
}
?><!--/join user-->
<?php

//functions
function pin_check($pin) {
    global $con, $userid;

    $query = mysqli_query($con, "SELECT * FROM `pin_list` WHERE `pin`='$pin' AND `user_id`='$userid' AND `status`='open'");
    if (mysqli_num_rows($query) > 0) {
        return true;
    } else {
        return false;
    }
}

function email_check($email) {
    global $con;

    $query = mysqli_query($con, "SELECT * FROM `user` WHERE `email`='$email'");
    if (mysqli_num_rows($query) > 0) {
        return false;
    } else {
        return true;
    }
}

function side_check($email, $side) {
    global $con;

    $query = mysqli_query($con, "SELECT * FROM `tree` WHERE `user_id`='$email'");
    $result = mysqli_fetch_array($query);
    $side_value = $result[$side];
    if ($side_value == '') {
        return true;
    } else {
        return false;
    }
}

function income($userid) {
    global $con;
    $data = array();
    $query = mysqli_query($con, "SELECT * FROM `income` WHERE `user_id`='$userid'");
    $result = mysqli_fetch_array($query);
    $data['day_bal'] = $result['day_bal'];
    $data['current_bal'] = $result['current_bal'];
    $data['total_bal'] = $result['total_bal'];

    return $data;
}

function tree($userid) {
    global $con;
    $data = array();
    $query = mysqli_query($con, "SELECT * FROM `tree` WHERE `user_id`='$userid'");
    $result = mysqli_fetch_array($query);
    $data['left'] = $result['left'];
    $data['right'] = $result['right'];
    $data['leftcount'] = $result['leftcount'];
    $data['rightcount'] = $result['rightcount'];

    return $data;
}

function getUnderId($userid) {
    global $con;
    $query = mysqli_query($con, "SELECT * FROM `user` WHERE `email`='$userid'");
    $result = mysqli_fetch_array($query);
    return $result['under_userid'];
}

function getUnderIdPlace($userid) {
    global $con;
    $query = mysqli_query($con, "SELECT * FROM `user` WHERE `email`='$userid'");
    $result = mysqli_fetch_array($query);
    return $result['side'];
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

        <title>Mlml Website  - Join</title>

        <!-- Bootstrap Core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">



    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
<?php include('include/menu.php'); ?>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Join</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-4">
                            <form method="get">
                                <div class="form-group">
                                    <label>Pin</label>
                                    <input type="text" name="pin" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" name="mobile" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Account</label>
                                    <input type="text" name="account" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Under Userid</label>
                                    <input type="text" name="under_userid" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Side</label><br>
                                    <input type="radio" name="side" value="left"> Left
                                    <input type="radio" name="side" value="right"> Right
                                </div>

                                <div class="form-group">
                                    <input type="submit" name="join_user" class="btn btn-primary" value="Join">
                                </div>
                            </form>
                        </div>
                    </div><!--/.row-->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

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
