<?php
include 'include/connect.php';
if(isset($_POST["id"])) {
//$sql = "SELECT * FROM `user` WHERE `email`='".$_POST["id"]."'";
	// $sql = "SELECT T.id, T.user_id, T.leftcount, T.rightcount, U.email, U.address, U.date, U.status, I.total_bal FROM USER U, tree T, income I WHERE T.user_id = U.email AND I.user_id = U.email AND I.user_id = '".$_POST["id"]."' ORDER BY T.id ASC";
	// $sql = "SELECT U.id, U.email, U.address, U.date, U.status,T.leftcount, T.rightcount, I.total_bal FROM USER U, tree T, income I WHERE T.user_id = U.email AND I.user_id = U.email AND I.user_id = '".$_POST["id"]."' ORDER BY U.id ASC ";
	$sql = "SELECT U.id, U.email, U.address, U.date, U.status,U.under_userid, T.leftcount, T.rightcount, I.total_bal FROM USER U, tree T, income I WHERE T.user_id = U.email AND I.user_id = U.email AND I.user_id = '".$_POST["id"]."' ORDER BY U.id ASC";
$resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));
$dev_data = array();
while( $rows = mysqli_fetch_assoc($resultset) ) {
$dev_data = $rows;
//print_r($rows);
}
echo json_encode($dev_data);
}
?>