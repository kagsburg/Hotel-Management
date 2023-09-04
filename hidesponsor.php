<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
$id=$_GET['id'];
$change=  mysqli_query($con,"UPDATE sponsors  SET status='0' WHERE sponsor_id='$id'") or die(mysqli_error($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
?>