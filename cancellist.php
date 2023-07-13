<?php
include "includes/conn.php"; //include config file
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Store Attendant')){
header('Location:login.php');
   }
 foreach($_SESSION["iproducts"] as $product){ //loop though items and prepare html content
             unset($_SESSION["iproducts"]);
 }
 header('Location:createlist');
			
?>
