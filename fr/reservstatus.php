<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
$id=$_GET['id'];
$st=$_GET['st'];
if($st=='1'){
$change=  mysqli_query($con,"UPDATE reservations  SET status='2' WHERE reservation_id='$id'") or die(mysqli_errno($con));
}
 else  if($st=='0'){
   $change=  mysqli_query($con,"UPDATE reservations  SET status='1' WHERE reservation_id='$id'") or die(mysqli_errno($con)); 
}

header('Location:'.$_SERVER['HTTP_REFERER']);
?>