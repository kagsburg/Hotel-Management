<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
$id=$_GET['id'];
$change=  mysqli_query($con,"UPDATE   hoteltables SET status='0' WHERE hoteltable_id='$id'") or die(mysql_errno($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
?>