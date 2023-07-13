<?php
include "includes/conn.php"; //include config file
 if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!="Restaurant Attendant")&& ($_SESSION['sysrole'] != 'Kitchen Exploitation Officer')){
header('Location:login.php');
   }
 foreach($_SESSION["rproducts"] as $product){ //loop though items and prepare html content
             unset($_SESSION["rproducts"]);
 }
 header('Location:addrestaurantorder');
			
?>
