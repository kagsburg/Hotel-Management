<?php
include 'includes/conn.php';
   if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login');
   }else{
$id=$_GET['id'];
$change=  mysqli_query($con,"UPDATE reservations SET status='2' WHERE  reservation_id='$id'") or die(mysqli_error($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>