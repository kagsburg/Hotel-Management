<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
$id=$_GET['id'];
$published=$_GET['status'];
$change=  mysqli_query($con,"UPDATE poolpackages  SET status='0' WHERE poolpackage_id='$id'") or die(mysql_errno($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
?>