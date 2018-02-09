<?php 
//session_start();
include 'include/connect.php';
include 'include/check-login.php';
$email=$_SESSION['userid'];
?>
<?php 
if(isset($_GET['pin_request'])){
    $amount=  mysqli_escape_string($con, "$_GET[amount]");
    
    $date=date("y-m-d");
    if($amount!=''){
       $query =mysqli_query($con, "INSERT INTO `pin_request`(`email`, `amount`, `date`) VALUES('$email','$amount','$date')");
        if($query){
          echo '<script>alert("pin request send successfully");window.location.assign("pin-request.php");</script>'; 
  
            
        }
 else {
     echo '<script>alert("unknown error occured");window.location.assign("pin-request.php");</script>'; 

 }
    }
 else {
        echo '<script>alert("please fill all the field")</script>';
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

    <div id="wrapper">

        <!-- Navigation -->
        <?php include 'include/menu.php';?>
        

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Pin Request</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-4">
                        <form method="get" action="">
                            <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="pin_request" class="btn btn-primary" value="Pin request">
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>S.n.</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                            <?php
                            $i=1;
                            $query=  mysqli_query($con, "SELECT * FROM `pin_request` WHERE `email`='$email' order by id desc");
                            if(mysqli_num_rows($query)>0){
                                while ($row=  mysqli_fetch_array($query)){
                                    $amount=$row['amount'];
                                    $date=$row['date'];
                                    $status=$row['status'];
                                    ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $amount; ?></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $status; ?></td>
                            </tr>
                            <?php
                            
                                    $i++;
                                }
                            }
                        else {
                            ?>
                            <tr>
                                <td colspan="4"> you have no pin request yet</td>
                            </tr>
                          <?php  
                        }
                            ?>
                        </table>
                    </div>
                </div>
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
