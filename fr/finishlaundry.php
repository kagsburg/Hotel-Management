<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
$id=$_GET['id'];
   $change=  mysqli_query($con,"UPDATE laundry  SET status='1' WHERE laundry_id='$id'") or die(mysqli_errno($con)); 
header('Location:laundryinvoice_print?id='.$id);
?>