<?php
include 'includes/conn.php';
   if((!isset($_SESSION['hotelsys']))/* ||($_SESSION['hotelsyslevel']!=1) */){
header('Location:login');
   }else{
$id=$_GET['id'];
// $change=  mysqli_query($con,"UPDATE hallreservations SET status='3' WHERE  hallreservation_id='$id'") or die(mysqli_error($con));
$change=  mysqli_query($con,"DELETE FROM hallreservations WHERE  hallreservation_id='$id'") or die(mysqli_error($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>