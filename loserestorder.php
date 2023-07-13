<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Restaurant Attendant')) {
   header('Location:login.php');
} else {
   $id = $_GET['id'];
   $change =  mysqli_query($con, "UPDATE orders SET orderstatus='Loss' WHERE order_id='$id'") or die(mysqli_errno($con));

   header('Location:' . $_SERVER['HTTP_REFERER']);
}
