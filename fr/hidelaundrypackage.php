<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
$id=$_GET['id'];
   $change=  mysqli_query($con,"UPDATE laundrypackages  SET status='0' WHERE laundrypackage_id='$id'") or die(mysqli_errno($con)); 
header('Location:'.$_SERVER['HTTP_REFERER']);
?>