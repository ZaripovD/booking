<?php require 'php/db.php';?>


<?php 

$data = $_POST;
  if (isset ($_SESSION['logged_user'])) {

  	$sesid = $_SESSION['logged_user']->id;
    
   if ($_SESSION['logged_user']->id_role == 2) {
     include("includes/header2.php"); 
   

  } else {
    include("includes/header1.php");  
}

} else {
  error_reporting(0);
    include("includes/header.php"); 
   

}


 ?>
</div> 

