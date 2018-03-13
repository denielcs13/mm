<?php 
include 'include/check-login.php';
include 'include/connect.php';
$userid=$_SESSION['userid'];
$search = $userid;
?>
<?php 
function tree_data($userid){
    global $con;
    $data=array();
    $query=  mysqli_query($con, "SELECT * FROM `tree` WHERE `user_id`='$userid'");
    $result=  mysqli_fetch_array($query);
    $data['left']=$result['left'];
    $data['right']=$result['right'];
    $data['leftcount']=$result['leftcount'];
    $data['rightcount']=$result['rightcount'];    
    return $data;  
    
}
?>
<?php
 if(isset($_GET['search-id'])){
     $search_id= mysqli_real_escape_string($con, $_GET['search-id']);
     if($search_id!=""){
         $query_check= mysqli_query($con, "SELECT * FROM `user` WHERE `email`='$search_id' ");
         if(mysqli_num_rows($query_check)>0){
             $search=$search_id;
         }
      else {
             echo '<script>alert("Access Denied");window.location.assign("tree.php");</script>';
      }
     }
 else {
         echo '<script>alert("Access Denied");window.location.assign("tree.php");</script>';
     
     }
     }
     //$search=$search_id;
     
     
 


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
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="ajax_data.js"></script>
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

<style>
    /*font.pos img{width:100%;}*/
    .table-responsive table tr td{border:0;   margin: 0; padding: 0;}
    .table-responsive tr td {height: auto;padding:0;margin: 0;}
    .table-responsive tr td p{padding:0;margin: 0;}
    .table-responsive tr {height: auto ;}
    tr.sec-tr font.pos img {width: 50%;}
    table.forth-ch font.pos {
    display: inline-block;
    text-align: center;
    width: 100%;
}

table.forth-ch img {
    width: 55% !important;
    left: 0 !important;
}

table.forth-ch table {
    width: 100%;
}
</style>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include 'include/menu.php';?>
        

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tree View</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-bordered" style="background: #1ab7ea">
<tbody><tr>
        <?php 
                                    $data=  tree_data($search);
                                    $q1= mysqli_query($con, "SELECT * FROM `user` WHERE `email`='$search' ");
                                    $userinfo=mysqli_fetch_assoc($q1);
                                    $q2=  mysqli_query($con, "SELECT * FROM `tree` WHERE `user_id`='$search'");
                                    $countinfo=  mysqli_fetch_assoc($q2);
                                    $q3=  mysqli_query($con, "SELECT * FROM `income` WHERE `user_id`='$search'");
                                    $income=  mysqli_fetch_assoc($q3);
                                    
                                    
                                   
         ?>
        <th colspan="10" style="background: #31b131;text-align:center"><h2><a href="#" onclick="ntree(1)" title=""></a> <?php echo $search; ?></h2>
</th></tr>
<tr>
  <th align="left">Address:</th><td colspan="3" align="left"> <?= $userinfo['address'] ?></td><th>Status:</th><td class="labl"><?= $userinfo['status'] ?></td></tr>
<!-- <tr><th align="left">BTC Purchase Address:</th><td colspan="3" align="left"> 1922eFxuK4sXDbGngf5KSWn8pMZveTwaWh</td><th>amount:</th><td class="labl">0 ZPR</td></tr>-->
 <tr><th align="left">Email Address:</th><td colspan="3" align="left"> <?= $userinfo['email'] ?></td><th>Total Paid:</th><td class="labl"><?= $income['total_bal'] ?></td></tr>
<tr><th align="left">Placement ID:</th><td align="left"><?= $userinfo['under_userid'] ?>  </td><th align="left">Placement :</th><td>    <?= $userinfo['side'] ?>
  </td><th align="left">Active Direct :</th><td> 0</td></tr>
  <tr><th align="left">Sponser ID:</th><td align="left"> </td><th align="left">Left coin :</th><td> 409355.704</td><th align="left">Right coin:</th><td> 0</td></tr>
  <tr><th align="left">Join Date:</th><td align="left"> <?= $userinfo['date'] ?></td><th align="left">Left Count:</th><td> <?= $countinfo['leftcount'] ?></td><th align="left">Right Count:</th><td> <?= $countinfo['rightcount'] ?></td></tr>
  </tbody></table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2"></div>
                     <form >
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input type="text" name="search-id" class="form-control">
                        </div>
                       
                    </div>
                         <div class="col-lg-2">
                        <div class="form-group">
                            <input type="submit" name="search" class="btn btn-primary" value="Search">
                        </div>
                       
                    </div>
                    </form>
                    <div class="col-lg-2"></div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table" align="center" border="0" style="text-align: center">
                                <tr height="150">
                                    
                                    <?php 
                                    $data=  tree_data($search);
                                    ?>
                                <table width="100%"  style="text-align:center;">
                                    
                                    <tr>                                        
                                        <td colspan=""><a href="#" class="hover" id="<?php echo $search; ?>"><i class="fa fa-user fa-4x" style="color: blue"></i><p><?php echo $search; ?></p></a>
                                        <font color="brown" class="pos"><br><img src="./images/genealogy_08.png" style="width: 50%;"></font>
                                    </td>                                   
                                    
                                    </tr>
                                </table>
                                </tr>
                                    
                                    
                                    
                                
                                
                                                                

                                <tr height="150"  class="sec-tr">
                                    <?php 
                                    $first_left_user= $data['left'];
                                    $first_right_user=$data['right'];
                                    ?>
                                    
                                    <table width="100%"  style="text-align:center;">                                    
                                    <tr>                                             
                                        <td colspan=""><i class="fa fa-user fa-4x" style="color: pink"></i><p>
                                                    
                                            <?php if($data['left']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $first_left_user; ?>"><?php echo $first_left_user;?></a>
                                       <?php }?>
                                           </p>
                                    <font color="brown" class="pos"><br><img src="./images/genealogy_08.png" style="width: 50%;width: 52%;position: relative;left: 9px;"></font></td>
                                    
                                        <td colspan=""><i class="fa fa-user fa-4x" style="color: pink"></i><p>
                                            <?php if($data['right']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $first_right_user; ?>"><?php echo $first_right_user;?></a>
                                       <?php }?></p>
                                    <font color="brown" class="pos"><br><img src="./images/genealogy_08.png"   style="width: 50%;"></font></td>
                                       
                                    </tr>
                                    </table>
                                    
                                </tr>
                                <tr height="150">
                                    <?php 
                                    $data_first_left_user=  tree_data($first_left_user);
                                    $second_left_user= $data_first_left_user['left'];
                                    $second_right_user =$data_first_left_user['right'];
                                    
                                    $data_first_right_user=  tree_data($first_right_user);
                                    $third_left_user= $data_first_right_user['left'];
                                    $third_right_user =$data_first_right_user['right'];
                                    ?>
                                    <table width="100%"  style="text-align:center;">
                                    
                                    <tr>
                                    <td colspan="">
                                <table width="100%">
                                    <tr>
                                       
                                        <td colspan=""><i class="fa fa-user fa-4x" style="color: #cc006a"></i><p>
                                            <?php if($data_first_left_user['left']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $second_left_user; ?>"><?php echo $second_left_user;?></a>
                                       <?php }?></p></td>
                                    
                                        <td colspan=""><i class="fa fa-user fa-4x" style="color: #cc006a"></i><p>
                                             <?php if($data_first_left_user['right']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $second_right_user; ?>"><?php echo $second_right_user;?></a>
                                       <?php }?></p></td>
                                   
                                    </tr>
                                </table>
                                    </td>
                                    
                                <td colspan="">
                                <table width="100%">
                                    <tr>
                                       
                                        <td colspan=""><i class="fa fa-user fa-4x" style="color: #cc006a"></i><p>
                                            <?php if($data_first_right_user['left']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $third_left_user; ?>"><?php echo $third_left_user;?></a>
                                       <?php }?></p></td>
                                    
                                        <td colspan=""><i class="fa fa-user fa-4x" style="color: #cc006a"></i><p>
                                            <?php if($data_first_right_user['right']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $third_right_user; ?>"><?php echo $third_right_user;?></a>
                                       <?php }?></p></td>
                                    
                                    </tr>
                                </table>
                                    </td>                                    
                                    </table>                                    
                                    </tr>
                                </tr
                                <tr height="150">                                    
                                    
                                    <?php 
                                    $data_second_left_user=  tree_data($second_left_user);
                                    $fourth_left_user=$data_second_left_user['left']; 
                                    $fouth_right_user =$data_second_left_user['right'];
                                    
                                    $data_second_right_user=  tree_data($second_right_user);
                                    $fourth_left_left_user=$data_second_right_user['left'];
                                    $fourth_left_right_user=$data_second_right_user['right'];
                                    
                                    $data_third_left_user=  tree_data($third_left_user);
                                    $fifth_left_user= $data_third_left_user['left'];
                                    $fifth_right_user =$data_third_left_user['right'];
                                    
                                    $data_third_right_user=  tree_data($third_right_user);
                                    $sixth_left_user=  $data_third_right_user['left'];
                                    $sixth_right_user=$data_third_right_user['right'];
                                    
                                    ?>
                                <table width="100%" style="text-align:center;" class="forth-ch">
                            <tr>
                                <td>
                                <table> 
                            <tr>
                                <font color="brown" class="pos"><br><img src="./images/genealogy_21.png" style="width: 50%;width: 52%;position: relative;left: 9px;"></font>
                                <td ><i class="fa fa-user fa-4x" style="color: #2672ec"></i><p>
                                    <?php if($data_second_left_user['left']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $fourth_left_user; ?>"><?php echo $fourth_left_user;?></a>
                                       <?php }?></p></td>
                                <td ><i class="fa fa-user fa-4x" style="color: #2672ec"></i><p>
                                    <?php if($data_second_left_user['right']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $fouth_right_user; ?>"><?php echo $fouth_right_user;?></a>
                                       <?php }?></p></td>
                            </tr>
                                 </table> 
                                </td>
                                
                                <td>
                                <table> 
                            <tr>
                                <font color="brown" class="pos"><br><img src="./images/genealogy_21.png" style="width: 50%;width: 52%;position: relative;left: 9px;"></font>
                                <td ><i class="fa fa-user fa-4x" style="color: #2672ec"></i><p>
                                    <?php if($data_second_right_user['left']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $fourth_left_left_user; ?>"><?php echo $fourth_left_left_user;?></a>
                                       <?php }?></p></td>
                                <td ><i class="fa fa-user fa-4x" style="color: #2672ec"></i><p>
                                    <?php if($data_second_right_user['right']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $fourth_left_right_user; ?>"><?php echo $fourth_left_right_user;?></a>
                                       <?php }?></p></td>
                            </tr>
                                 </table> 
                                </td>
                                
                                 <td>
                                <table> 
                            <tr>
                                <font color="brown" class="pos"><br><img src="./images/genealogy_21.png" style="width: 50%;width: 52%;position: relative;left: 9px;"></font>
                                <td ><i class="fa fa-user fa-4x" style="color: #2672ec"></i><p>
                                    <?php if($data_third_left_user['left']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $fifth_left_user; ?>"><?php echo $fifth_left_user;?></a>
                                       <?php }?></p></td>
                                <td ><i class="fa fa-user fa-4x" style="color: #2672ec"></i><p>
                                    <?php if($data_third_left_user['right']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $fifth_right_user; ?>"><?php echo $fifth_right_user;?></a>
                                       <?php }?></p></td>
                            </tr>
                                 </table> 
                                </td>
                                
                                <td>
                                <table> 
                            <tr>
                                <font color="brown" class="pos"><br><img src="./images/genealogy_21.png" style="width: 50%;width: 52%;position: relative;left: 9px;"></font>
                                <td ><i class="fa fa-user fa-4x" style="color: #2672ec"></i><p>
                                    <?php if($data_third_right_user['left']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $sixth_left_user; ?>"><?php echo $sixth_left_user;?></a>
                                       <?php }?></p></td>
                                <td ><i class="fa fa-user fa-4x" style="color: #2672ec"></i><p>
                                    <?php if($data_third_right_user['right']==""){
                                                
                                              echo 'NA';
                                                
                                            }
                                        else {
                                            ?>
                                          <a href="#" class="hover" id="<?php echo $sixth_right_user; ?>"><?php echo $sixth_right_user;?></a>
                                       <?php }?></p></td>
                                 </tr>
                                 </table> 
                                </td>
                                 
                            </tr>
                                
                            </tr>
                                 
                                
                                </table> 
                                
                                
                                
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="popover_html" style="width: 30em; display:none;">
<table class="table" >
<tbody><tr><th>Login ID</th><th>Name</th><th>Total Bal</th></tr>
<tr><td>p_id (p_id)</td><td>p_name</td><td>p_bal</td></tr>
<tr><th>Date</th><th>Sponser ID</th><th>Status</th></tr>
<tr><td>p_design</td><td>p_sid</td><td>p_gender</td></tr>
<tr><th>Address</th><th>Left Count</th><th>Right Count</th></tr>
<tr><td>p_address</td><td>p_age</td><td>p_rightcount</td></tr></tbody>
</table>
</div> 
           <br>
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
