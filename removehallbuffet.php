<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
      }else{
$id=$_GET['id'];
$change=  mysqli_query($con,"UPDATE hallbuffets SET status='0' WHERE hallbuffet_id='$id'") or die(mysqli_error($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>