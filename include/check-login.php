<?php 
session_start();
if(isset($_SESSION['id'])&& $_SESSION['login_type']=='user'){
    
}
 else {
echo '<script>alert("access denied");window.location.assign("index.php");</script>'; 
   
}

?>