<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
      }else{
$id=$_GET['id'];
// $change=  mysqli_query($con,"UPDATE poolsubscriptions SET status='0' WHERE poolsubscription_id='$id'") or die(mysqli_error($con));
$change=  mysqli_query($con,"DELETE FROM poolsubscriptions WHERE poolsubscription_id='$id'") or die(mysqli_error($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>