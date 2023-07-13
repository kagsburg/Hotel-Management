<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
   }else{
$id=$_GET['id'];
$change=  mysqli_query($con,"UPDATE suppliers SET status='0' WHERE  supplier_id='$id'") or die(mysqli_error($con));
header('Location:'.$_SERVER['HTTP_REFERER']);
   }
?>